<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sponsor = \App\Models\Sponsor::where('user_id', 3)->first();
if ($sponsor) {
    echo "Found: {$sponsor->name} (ID: {$sponsor->id})" . PHP_EOL;
} else {
    echo "Not found for user_id 3" . PHP_EOL;
}

// Check all sponsors
$sponsors = \App\Models\Sponsor::all();
foreach ($sponsors as $s) {
    echo "Sponsor: {$s->name}, User ID: {$s->user_id}" . PHP_EOL;
}