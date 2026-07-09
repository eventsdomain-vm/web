<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sponsor = \App\Models\Sponsor::with(['contracts'])->first();
echo "Sponsor: " . ($sponsor ? $sponsor->name : 'not found') . PHP_EOL;

$contracts = $sponsor->contracts;
echo "Contracts type: " . gettype($contracts) . PHP_EOL;
echo "Contracts class: " . get_class($contracts) . PHP_EOL;

if ($contracts instanceof \Illuminate\Database\Eloquent\Collection) {
    echo "Count: " . $contracts->count() . PHP_EOL;
}

$whereResult = $contracts->where('signed_at');
echo "Where result type: " . gettype($whereResult) . " class: " . get_class($whereResult) . PHP_EOL;

if ($whereResult instanceof \Illuminate\Database\Eloquent\Collection) {
    echo "Where count: " . $whereResult->count() . PHP_EOL;
    $isNotEmpty = $whereResult->isNotEmpty();
    echo "isNotEmpty: " . ($isNotEmpty ? 'true' : 'false') . PHP_EOL;
    if ($isNotEmpty) {
        echo "Where count after isNotEmpty: " . $whereResult->count() . PHP_EOL;
    }
}