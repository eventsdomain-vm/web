<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create sponsor for user ID 3
$user = \App\Models\User::find(3);
if ($user) {
    $sponsor = \App\Models\Sponsor::create([
        'user_id' => $user->id,
        'uuid' => \Illuminate\Support\Str::uuid(),
        'name' => $user->name . ' Company',
        'slug' => \Illuminate\Support\Str::slug($user->name . ' Company'),
        'industry' => 'Technology',
        'description' => 'A leading sponsor company',
        'org_type' => 'corporation',
        'registration_number' => 'REG123456',
        'tax_id' => 'TAX123456',
        'business_email' => $user->email,
        'business_phone' => '+91-9876543210',
        'timezone' => 'Asia/Kolkata',
        'default_currency' => 'INR',
        'fiscal_year' => '2026',
        'org_status' => 'active',
        'is_verified' => true,
    ]);
    echo "Created sponsor: {$sponsor->name} (ID: {$sponsor->id}) for user {$user->name}" . PHP_EOL;
} else {
    echo "User not found" . PHP_EOL;
}