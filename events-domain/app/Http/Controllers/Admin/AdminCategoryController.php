<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $category = Category::create($validated);

        $this->logActivity(
            'category_created',
            "Category '{$category->name}' created",
            $category,
            $validated
        );

        return redirect()->route('admin.categories')
            ->with('success', 'Category created successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $category->update($validated);

        $this->logActivity(
            'category_updated',
            "Category '{$category->name}' updated",
            $category,
            $validated
        );

        return redirect()->route('admin.categories')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->events()->exists() || $category->partnerServices()->exists()) {
            return redirect()->route('admin.categories')
                ->with('error', 'Cannot delete category with associated events or services.');
        }

        $name = $category->name;
        $category->delete();

        $this->logActivity(
            'category_deleted',
            "Category '{$name}' deleted"
        );

        return redirect()->route('admin.categories')
            ->with('success', 'Category deleted successfully!');
    }
}
