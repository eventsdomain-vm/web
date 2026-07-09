<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$e = \App\Models\Event::where('slug','titodi-garba')->first();
$galleryImages = $e->gallery->pluck('image_url')->filter(fn($p) => !empty($p))->map(function ($p) {
    if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) return $p;
    try {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($p)) return \Illuminate\Support\Facades\Storage::url($p);
    } catch (\Throwable $e) { echo 'Error: '.$e->getMessage().PHP_EOL; }
    return null;
})->filter()->values();
echo 'Gallery images found: '.$galleryImages->count().PHP_EOL;
echo json_encode($galleryImages->toArray()).PHP_EOL;
$heroImages = $galleryImages->isNotEmpty() ? $galleryImages : collect([$e->cover_image_url])->filter()->values();
echo 'Hero images: '.$heroImages->count().PHP_EOL;
echo json_encode($heroImages->toArray()).PHP_EOL;
