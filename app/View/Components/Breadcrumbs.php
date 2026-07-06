<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    private const TITLE_MAP = [
        'dashboard' => 'Home',
        'admin' => 'Admin',
        'organizer' => 'Organizer',
        'sponsor' => 'Sponsor',
        'partner' => 'Partner',
        'events' => 'Events',
        'users' => 'Users',
        'categories' => 'Categories',
        'roles' => 'Roles',
        'settings' => 'Settings',
        'logs' => 'Activity Logs',
        'reports' => 'Reports',
        'cms' => 'CMS',
        'sponsorships' => 'Sponsorships',
        'partners' => 'Partners',
        'packages' => 'Packages',
        'gallery' => 'Gallery',
        'schedules' => 'Schedules',
        'team' => 'Team',
        'social' => 'Social Accounts',
        'posts' => 'Social Posts',
        'create' => 'Create',
        'edit' => 'Edit',
        'pending' => 'Pending',
        'profile' => 'Profile',
        'messages' => 'Messages',
        'analytics' => 'Analytics',
        'enquiries' => 'Enquiries',
    ];

    public array $items = [];

    public function __construct()
    {
        $this->items = $this->generateItems();
    }

    private function generateItems(): array
    {
        $path = request()->path();
        $segments = array_filter(explode('/', $path));

        if (empty($segments)) {
            return [['title' => 'Home', 'href' => null]];
        }

        $items = [['title' => 'Home', 'href' => route('dashboard')]];
        $builtPath = '';

        foreach ($segments as $index => $segment) {
            $builtPath .= '/'.$segment;
            $isLast = $index === array_key_last($segments);
            $title = $this->resolveTitle($segment);

            // Hide duplicates (e.g., "admin" appearing twice)
            $prevTitle = $items[count($items) - 1]['title'] ?? '';
            if ($title === $prevTitle) {
                continue;
            }

            $items[] = [
                'title' => $title,
                'href' => $isLast ? null : $builtPath,
            ];
        }

        return $items;
    }

    private function resolveTitle(string $segment): string
    {
        if (isset(self::TITLE_MAP[$segment])) {
            return self::TITLE_MAP[$segment];
        }

        // Check if it's a numeric ID — skip it
        if (is_numeric($segment)) {
            return '';
        }

        // Convert slug to Title Case
        return Str::title(str_replace('-', ' ', $segment));
    }

    public function render()
    {
        // Filter out empty titles (numeric IDs)
        $this->items = array_values(array_filter($this->items, fn (array $item) => ! empty($item['title'])));

        return view('components.ui.breadcrumb');
    }
}
