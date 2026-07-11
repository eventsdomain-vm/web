<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Event;
use App\Models\SponsorshipPackage;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
class AdminSitemapController extends Controller
{
    public function index(): View
    {
        $sitemapPaths = $this->getSitemapPaths();

        return view('admin.seo.sitemap', compact('sitemapPaths'));
    }

    public function generate()
    {
        return response()->stream(function () {
            $paths = $this->getSitemapPaths();
            $today = now()->format('Y-m-d');

            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

            foreach ($paths as $path) {
                echo '    <url>' . "\n";
                echo '        <loc>' . htmlspecialchars($path) . '</loc>' . "\n";
                echo '        <lastmod>' . $today . '</lastmod>' . "\n";
                echo '        <priority>0.8</priority>' . "\n";
                echo '    </url>' . "\n";
            }

            echo '</urlset>' . "\n";
        }, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'no-cache',
        ]);
    }

    public function download()
    {
        return $this->generate();
    }

    private function getSitemapPaths(): array
    {
        $paths = [];

        $staticRoutes = ['home', 'events.index', 'about', 'contact', 'faq', 'privacy', 'terms', 'pricing'];
        foreach ($staticRoutes as $name) {
            if (Route::has($name)) {
                $paths[$name] = route($name);
            }
        }

        $events = Event::whereNotNull('slug')
            ->where('status', 'approved')
            ->where('approval_status', 'approved')
            ->get(['slug']);

        if (Route::has('events.show')) {
            foreach ($events as $event) {
                $paths['event_'.$event->id] = route('events.show', $event->slug);
            }
        }

        if (Route::has('sponsor.packages.show')) {
            $sponsorshipPackages = SponsorshipPackage::where('is_active', true)->get(['id']);
            foreach ($sponsorshipPackages as $package) {
                $paths['package_'.$package->id] = route('sponsor.packages.show', $package->id);
            }
        }

        if (Route::has('page.show')) {
            $cmsPages = CmsPage::where('is_published', true)->get(['slug']);
            foreach ($cmsPages as $page) {
                $paths['page_'.$page->id] = route('page.show', $page->slug);
            }
        }

        if (Route::has('categories.show')) {
            $categories = Category::where('is_active', true)->get(['slug']);
            foreach ($categories as $category) {
                $paths['category_'.$category->id] = route('categories.show', $category->slug);
            }
        }

        return $paths;
    }


}
