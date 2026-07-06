<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\Event;
use App\Models\SeoSetting;
use App\Models\SponsorshipPackage;
use Illuminate\View\View;

class AdminSeoDashboardController extends Controller
{
    public function index(): View
    {
        $seoStats = [
            'indexed_pages' => $this->getIndexedPagesCount(),
            'missing_meta' => $this->getMissingMetaCount(),
            'pages_without_title' => $this->getPagesWithoutTitleCount(),
            'missing_alt_images' => $this->getMissingAltImagesCount(),
            'pages_without_canonical' => $this->getPagesWithoutCanonicalCount(),
            'duplicate_titles' => $this->getDuplicateTitlesCount(),
            'duplicate_descriptions' => $this->getDuplicateDescriptionsCount(),
            'broken_internal_links' => $this->getBrokenInternalLinksCount(),
            'status_404_pages' => $this->getStatus404PagesCount(),
            'sitemap_status' => $this->getSitemapStatus(),
            'robots_status' => $this->getRobotsStatus(),
            'average_seo_score' => $this->getAverageSeoScore(),
            'google_search_console_status' => $this->getGoogleSearchConsoleStatus(),
        ];

        $recentSeoIssues = $this->getRecentSeoIssues();

        $seoTrends = $this->getSeoTrends();

        return view('admin.seo.dashboard', compact('seoStats', 'recentSeoIssues', 'seoTrends'));
    }

    private function getIndexedPagesCount(): int
    {
        $count = Event::whereNotNull('slug')
            ->where('status', 'published')
            ->where('approval_status', 'approved')
            ->count();

        $count += SponsorshipPackage::count();
        $count += CmsPage::count();

        return $count;
    }

    private function getMissingMetaCount(): int
    {
        return SeoSetting::whereNotIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class])
            ->where(function ($query) {
                $query->whereNull('meta_title')
                    ->orWhereNull('meta_description');
            })
            ->count();
    }

    private function getPagesWithoutTitleCount(): int
    {
        return SeoSetting::whereNull('meta_title')
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class])
            ->count();
    }

    private function getMissingAltImagesCount(): int
    {
        return 0;
    }

    private function getPagesWithoutCanonicalCount(): int
    {
        return SeoSetting::whereNull('canonical_url')
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class])
            ->where(function ($query) {
                $query->whereNotNull('seoable_id');
            })
            ->count();
    }

    private function getDuplicateTitlesCount(): int
    {
        $seoSettings = SeoSetting::whereNotNull('meta_title')
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class])
            ->get(['seoable_type', 'seoable_id', 'meta_title']);

        $titleCounts = $seoSettings->groupBy('meta_title')->filter(function ($items, $title) {
            return count($items) > 1;
        })->count();

        return $titleCounts;
    }

    private function getDuplicateDescriptionsCount(): int
    {
        $seoSettings = SeoSetting::whereNotNull('meta_description')
            ->whereIn('seoable_type', [Event::class, CmsPage::class, SponsorshipPackage::class])
            ->get(['seoable_type', 'seoable_id', 'meta_description']);

        $descriptionCounts = $seoSettings->groupBy('meta_description')->filter(function ($items, $desc) {
            return count($items) > 1;
        })->count();

        return $descriptionCounts;
    }

    private function getBrokenInternalLinksCount(): int
    {
        return 0;
    }

    private function getStatus404PagesCount(): int
    {
        return 0;
    }

    private function getSitemapStatus(): string
    {
        return 'generated'; // Placeholder
    }

    private function getRobotsStatus(): string
    {
        return 'published'; // Placeholder
    }

    private function getAverageSeoScore(): float
    {
        $seoSettings = SeoSetting::whereNotNull('seoable_id')
            ->where('seo_score', '>', 0)
            ->get(['seo_score']);

        if ($seoSettings->isEmpty()) {
            return 0.0;
        }

        return round($seoSettings->avg('seo_score'), 2);
    }

    private function getGoogleSearchConsoleStatus(): string
    {
        return 'connected'; // Placeholder
    }

    private function getRecentSeoIssues(): array
    {
        $recentSeoSettings = SeoSetting::where('updated_at', '>=', now()->subDays(7))
            ->with('seoable')
            ->take(5)
            ->get();

        return $recentSeoSettings->map(function ($seo) {
            return [
                'id' => $seo->id,
                'model_type' => $seo->seoable_type,
                'model_id' => $seo->seoable_id,
                'model_title' => $seo->seoable->title ?? $seo->seoable->name ?? 'Unknown',
                'title' => $seo->meta_title ?? 'Missing',
                'description' => $seo->meta_description ?? 'Missing',
                'score' => $seo->seo_score,
                'updated_at' => $seo->updated_at,
            ];
        })->toArray();
    }

    private function getSeoTrends(): array
    {
        $currentScore = round(
            SeoSetting::where('updated_at', '>=', now()->subDays(30))
                ->whereNotNull('seo_score')
                ->where('seo_score', '>', 0)
                ->avg('seo_score') ?? 0,
            2
        );

        return [
            'current_score' => $currentScore,
            'trend_direction' => 'up',
        ];
    }
}
