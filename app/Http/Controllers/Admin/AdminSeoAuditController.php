<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Event;
use App\Models\SeoAudit;
use App\Models\SeoSetting;
use App\Models\SponsorshipPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminSeoAuditController extends Controller
{
    public function index(): View
    {
        $seoIssues = $this->getSeoIssues();

        return view('admin.seo.audit', compact('seoIssues'));
    }

    public function show($auditable_type, $auditable_id): View
    {
        $audit = SeoAudit::where('auditable_type', $auditable_type)
            ->where('auditable_id', $auditable_id)
            ->firstOrFail();

        return view('admin.seo.audit-details', compact('audit'));
    }

    public function scheduleScan(): RedirectResponse
    {
        // Schedule immediate SEO audit
        // This could be a queued job
        SeoAudit::create([
            'auditable_type' => 'system',
            'auditable_id' => 1,
            'results' => [],
            'score' => 0,
            'completed_at' => now(),
        ]);

        return redirect()->route('admin.seo.audit')
            ->with('success', 'SEO audit scheduled successfully!');
    }

    private function getSeoIssues(): array
    {
        $issues = [];

        // Missing meta titles
        $missingTitles = SeoSetting::where('meta_title', null)
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class, Category::class])
            ->count();

        $issues[] = [
            'type' => 'missing_meta_title',
            'count' => $missingTitles,
            'severity' => 'high',
        ];

        // Missing meta descriptions
        $missingDescriptions = SeoSetting::where('meta_description', null)
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class, Category::class])
            ->count();

        $issues[] = [
            'type' => 'missing_meta_description',
            'count' => $missingDescriptions,
            'severity' => 'high',
        ];

        // Missing canonical URLs
        $missingCanonical = SeoSetting::where('canonical_url', null)
            ->whereNotNull('seoable_id')
            ->count();

        $issues[] = [
            'type' => 'missing_canonical_url',
            'count' => $missingCanonical,
            'severity' => 'medium',
        ];

        // Duplicate titles
        $duplicateTitles = $this->getDuplicateTitlesCount();

        $issues[] = [
            'type' => 'duplicate_titles',
            'count' => $duplicateTitles,
            'severity' => 'medium',
        ];

        // Duplicate descriptions
        $duplicateDescriptions = $this->getDuplicateDescriptionsCount();

        $issues[] = [
            'type' => 'duplicate_descriptions',
            'count' => $duplicateDescriptions,
            'severity' => 'medium',
        ];

        // Missing ALT images
        $missingAltImages = $this->getMissingAltImagesCount();

        $issues[] = [
            'type' => 'missing_alt_images',
            'count' => $missingAltImages,
            'severity' => 'low',
        ];

        // Issues in pending or draft items
        $pendingIssues = $this->getPendingItemIssues();

        $issues[] = [
            'type' => 'pending_items',
            'count' => $pendingIssues,
            'severity' => 'high',
        ];

        return $issues;
    }

    private function getDuplicateTitlesCount(): int
    {
        return SeoSetting::whereNotNull('meta_title')
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class, Category::class])
            ->select('meta_title')
            ->groupBy('meta_title')
            ->havingRaw('COUNT(*) > 1')
            ->count();
    }

    private function getDuplicateDescriptionsCount(): int
    {
        return SeoSetting::whereNotNull('meta_description')
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class, Category::class])
            ->select('meta_description')
            ->groupBy('meta_description')
            ->havingRaw('COUNT(*) > 1')
            ->count();
    }

    private function getMissingAltImagesCount(): int
    {
        return 0; // Placeholder for image scanning
    }

    private function getPendingItemIssues(): int
    {
        $pendingEvents = Event::where('status', 'pending')
            ->where('approval_status', '!=', 'approved')
            ->count();

        $draftEvents = Event::where('status', 'draft')
            ->count();

        return $pendingEvents + $draftEvents;
    }
}
