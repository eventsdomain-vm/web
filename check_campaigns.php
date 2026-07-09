<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sponsor = \App\Models\Sponsor::first();
$campaigns = $sponsor->campaigns;
echo "Campaigns Type: " . gettype($campaigns) . "\n";
echo "Campaigns Class: " . get_class($campaigns) . "\n";
if ($campaigns instanceof \Illuminate\Database\Eloquent\Collection) {
    echo "Count: " . $campaigns->count() . "\n";
}