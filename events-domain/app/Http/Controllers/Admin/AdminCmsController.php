<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCmsController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $pages = CmsPage::latest()->paginate(20);

        return view('admin.cms', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.cms-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', false);

        $page = CmsPage::create($validated);

        $this->logActivity(
            'cms_page_created',
            "CMS page '{$page->title}' created",
            $page,
            $validated
        );

        return redirect()->route('admin.cms')
            ->with('success', 'CMS page created successfully!');
    }

    public function edit(CmsPage $cmsPage): View
    {
        return view('admin.cms-edit', ['page' => $cmsPage]);
    }

    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', false);

        $cmsPage->update($validated);

        $this->logActivity(
            'cms_page_updated',
            "CMS page '{$cmsPage->title}' updated",
            $cmsPage,
            $validated
        );

        return redirect()->route('admin.cms')
            ->with('success', 'CMS page updated successfully!');
    }

    public function destroy(CmsPage $cmsPage)
    {
        $title = $cmsPage->title;
        $cmsPage->delete();

        $this->logActivity(
            'cms_page_deleted',
            "CMS page '{$title}' deleted"
        );

        return redirect()->route('admin.cms')
            ->with('success', 'CMS page deleted successfully!');
    }
}
