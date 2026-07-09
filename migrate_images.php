<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$media = \App\Models\EventMedia::where('event_id', 19)->get();
foreach ($media as $m) {
    \App\Models\EventGallery::create([
        'event_id' => 19,
        'image_url' => $m->path,
        'sort_order' => $m->sort_order,
    ]);
}
$event = \App\Models\Event::find(19);
if (!$event->cover_image && $media->first()) {
    $event->update(['cover_image' => $media->first()->path]);
}
echo 'Migrated ' . $media->count() . " images to event_gallery\n";
