<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AdminRobotsController extends Controller
{
    public function index(): View
    {
        $robotsRules = [
            'allow' => $this->getRobotsRules('allow'),
            'disallow' => $this->getRobotsRules('disallow'),
            'crawl_delay' => $this->getRobotsRules('crawl_delay'),
        ];

        return view('admin.seo.robots', compact('robotsRules'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'allow' => 'nullable|string',
            'disallow' => 'nullable|string',
            'crawl_delay' => 'nullable|integer|min:0|max:300',
            'sitemap_url' => 'nullable|url',
        ]);

        $this->saveRobotsRules($validated);

        return redirect()->back()->with('success', 'robots.txt updated successfully!');
    }

    private function getRobotsRules($type)
    {
        $rules = $this->getCurrentRobotsRules();

        return $rules[$type] ?? null;
    }

    private function getCurrentRobotsRules(): array
    {
        return [
            'allow' => '/',
            'disallow' => '/admin/',
            'crawl_delay' => 0,
            'sitemap_url' => Route::has('sitemap.xml') ? route('sitemap.xml') : url('/sitemap.xml'),
        ];
    }

    private function saveRobotsRules($rules): void
    {
        // This would write to actual robots.txt file
        // For now, we'll store in cache or database
        cache()->put('robots_rules', $rules, now()->addDays(7));
    }
}
