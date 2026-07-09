<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();

// Add deleted_at column to sponsor_objectives
$pdo->exec("
ALTER TABLE `sponsor_objectives` ADD COLUMN `deleted_at` timestamp NULL AFTER `updated_at`;
");
echo "Added deleted_at to sponsor_objectives\n";

// Add deleted_at column to sponsor_preferences
$pdo->exec("
ALTER TABLE `sponsor_preferences` ADD COLUMN `deleted_at` timestamp NULL AFTER `updated_at`;
");
echo "Added deleted_at to sponsor_preferences\n";

// Add deleted_at column to sponsor_budget_allocations
$pdo->exec("
ALTER TABLE `sponsor_budget_allocations` ADD COLUMN `deleted_at` timestamp NULL AFTER `updated_at`;
");
echo "Added deleted_at to sponsor_budget_allocations\n";

echo "All deleted_at columns added!\n";