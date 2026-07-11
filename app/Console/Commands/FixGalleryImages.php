<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FixGalleryImages extends Command
{
    protected $signature = 'fix:gallery-images';

    protected $description = 'Download remote gallery images to local storage';

    public function handle()
    {
        $this->info('Checking gallery images...');

        $images = DB::table('event_gallery')
            ->where('image_url', 'like', 'http%')
            ->get();

        $this->info("Found {$images->count()} remote images to download");

        $downloaded = 0;
        $failed = 0;

        foreach ($images as $img) {
            $this->info("  Processing image #{$img->id} for event #{$img->event_id}");

            $local = $this->downloadImage($img->image_url, "events/{$img->event_id}/gallery");

            if ($local) {
                DB::table('event_gallery')
                    ->where('id', $img->id)
                    ->update(['image_url' => $local]);
                $downloaded++;
                $this->info("    Downloaded: $local");
            } else {
                $this->warn('    Failed to download, removing broken entry');
                DB::table('event_gallery')
                    ->where('id', $img->id)
                    ->delete();
                $failed++;
            }
        }

        $this->info("Done. Downloaded: $downloaded, Removed broken: $failed");

        // Also update cover_image for any events that have a remote URL
        $events = DB::table('events')
            ->where('cover_image', 'like', 'http%')
            ->get();

        foreach ($events as $event) {
            $this->info("Fixing cover_image for event #{$event->id}: {$event->title}");
            $local = $this->downloadImage($event->cover_image, "events/{$event->id}");
            if ($local) {
                DB::table('events')->where('id', $event->id)->update(['cover_image' => $local]);
            }
        }

        return 0;
    }

    private function downloadImage($url, $subdir)
    {
        if (empty($url) || ! str_starts_with($url, 'http')) {
            return null;
        }

        try {
            $response = Http::timeout(30)->withHeaders([
                'apikey' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVrenV3cmJoam9sYnd4cXNxbG5wIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjgzNzQ5MDUsImV4cCI6MjA4Mzk1MDkwNX0.LnnaHKJQDzNzKHW9hHSf0P-b31KOA09y3X0-SB8QGew',
            ])->get($url);

            if (! $response->successful()) {
                return null;
            }

            $path = parse_url($url, PHP_URL_PATH);
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif', 'svg'])) {
                $ext = 'jpg';
            }

            $filename = Str::random(32).'.'.$ext;
            $storagePath = "{$subdir}/{$filename}";
            Storage::disk('public')->put($storagePath, $response->body());

            return $storagePath;
        } catch (\Exception $e) {
            return null;
        }
    }
}
