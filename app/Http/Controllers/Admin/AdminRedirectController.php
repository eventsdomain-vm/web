<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminRedirectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Redirect::query();

        if ($request->filled('source_url')) {
            $query->where('source_url', 'like', "%{$request->source_url}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $redirects = $query->latest()->paginate(20);

        return view('admin.seo.redirects', compact('redirects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_url' => 'required|url|unique:redirects,source_url',
            'target_url' => 'required|url',
            'type' => ['required', Rule::in(['301', '302', '307', '308', '410'])],
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $redirect = Redirect::create($validated);

        return redirect()->route('admin.seo.redirects')
            ->with('success', 'Redirect created successfully!');
    }

    public function update(Request $request, Redirect $redirect): RedirectResponse
    {
        $validated = $request->validate([
            'source_url' => ['required', 'url', Rule::unique('redirects', 'source_url')->ignore($redirect->id)],
            'target_url' => 'required|url',
            'type' => ['required', Rule::in(['301', '302', '307', '308', '410'])],
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->boolean('is_active', $redirect->is_active);

        $redirect->update($validated);

        return redirect()->back()->with('success', 'Redirect updated successfully!');
    }

    public function destroy(Redirect $redirect): RedirectResponse
    {
        $redirect->delete();

        return redirect()->route('admin.seo.redirects')
            ->with('success', 'Redirect deleted successfully!');
    }
}
