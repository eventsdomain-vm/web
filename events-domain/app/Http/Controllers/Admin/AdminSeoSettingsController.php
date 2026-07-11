<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Event;
use App\Models\PlatformSetting;
use App\Models\SeoSetting;
use App\Models\SponsorshipPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSeoSettingsController extends Controller
{
    public function index(): View
    {
        $globalSettings = PlatformSetting::whereIn('group', ['global', 'general'])
            ->get()
            ->groupBy('group');

        $pageTypes = [
            'event' => Event::class,
            'sponsorship_package' => SponsorshipPackage::class,
            'cms_page' => CmsPage::class,
            'category' => Category::class,
        ];

        $seoSettings = collect();
        foreach ($pageTypes as $type => $model) {
            $existing = SeoSetting::where('seoable_type', $model)
                ->where('is_active', true)
                ->first();

            if ($existing) {
                $seoSettings[$type] = $existing;
            } else {
                $seoSettings[$type] = new SeoSetting;
                $seoSettings[$type]->seoable_type = $model;
                $seoSettings[$type]->is_active = true;
            }
        }

        return view('admin.seo.settings', compact('globalSettings', 'seoSettings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'global' => 'required|array',
            'global.site_name' => 'nullable|string|max:255',
            'global.site_tagline' => 'nullable|string|max:500',
            'global.meta_description' => 'nullable|string|max:500',
            'global.meta_keywords' => 'nullable|string|max:1000',
            'global.default_author' => 'nullable|string|max:255',
            'global.publisher_name' => 'nullable|string|max:255',
            'global.og_image' => 'nullable|string|max:255',
            'global.twitter_card_image' => 'nullable|string|max:255',
            'global.default_language' => 'nullable|string|size:2',
            'global.default_country' => 'nullable|string|max:2',
            'global.theme_color' => 'nullable|string|max:7',
            'global.favicon' => 'nullable|string|max:255',
            'global.google_verification_code' => 'nullable|string|max:255',
            'global.bing_verification_code' => 'nullable|string|max:255',
            'global.yandex_verification_code' => 'nullable|string|max:255',
        ]);

        $group = $validated['global'] ?? [];

        foreach ($group as $key => $value) {
            PlatformSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'string', 'group' => 'global']
            );
        }

        return redirect()->back()->with('success', 'SEO settings updated successfully!');
    }
}
