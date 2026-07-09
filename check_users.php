<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check all users and their sponsors
$users = \App\Models\User::with('roles')->get();
foreach ($users as $user) {
    $roles = $user->roles->pluck('name')->implode(', ');
    echo "User: {$user->name} (ID: {$user->id}), Email: {$user->email}, Roles: {$roles}" . PHP_EOL;
}

// Check all sponsors
$sponsors = \App\Models\Sponsor::with('user')->get();
echo "\nSponsors:\n";
foreach ($sponsors as $s) {
    $userName = $s->user ? $s->user->name : 'N/A';
    echo "Sponsor: {$s->name}, User: {$userName}, User ID: {$s->user_id}" . PHP_EOL;
}