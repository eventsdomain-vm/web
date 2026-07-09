<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sponsor = \App\Models\Sponsor::first();
$contracts = $sponsor->contracts;
echo "Type: " . gettype($contracts) . "\n";
echo "Class: " . get_class($contracts) . "\n";
if ($contracts instanceof \Illuminate\Database\Eloquent\Collection) {
    echo "Count: " . $contracts->count() . "\n";
}