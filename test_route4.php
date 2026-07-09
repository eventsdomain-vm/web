<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a request with a logged-in sponsor user
$user = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'sponsor'); })->first();

if (!$user) {
    echo "No sponsor user found!" . PHP_EOL;
    exit(1);
}

echo "Testing as: {$user->name} (ID: {$user->id})" . PHP_EOL;
echo "Has sponsor role: " . ($user->hasRole('sponsor') ? 'yes' : 'no') . PHP_EOL;

// Check sponsor record
$sponsor = \App\Models\Sponsor::where('user_id', $user->id)->first();
if ($sponsor) {
    echo "Sponsor record: {$sponsor->name} (ID: {$sponsor->id})" . PHP_EOL;
} else {
    echo "NO SPONSOR RECORD for user {$user->id}!" . PHP_EOL;
}

// Now test the route with the actual request handling
$request = \Illuminate\Http\Request::create('/sponsor/plan/objectives', 'GET');
$request->headers->set('Host', 'vm.site');

// Manually set the user on the request
$request->setUserResolver(function() use ($user) { return $user; });

// Also set the session to simulate authentication
$session = $app->make('session.store');
$session->put('login_web_' . sha1('web'), $user->getAuthIdentifier());
$request->setLaravelSession($session);

// Set the user on the auth guard
\Illuminate\Support\Facades\Auth::guard('web')->setUser($user);

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request);

echo 'Status: ' . $response->getStatusCode() . PHP_EOL;
if ($response->getStatusCode() !== 200) {
    echo 'Content: ' . substr($response->getContent(), 0, 1000) . PHP_EOL;
} else {
    echo 'Success! Content length: ' . strlen($response->getContent()) . PHP_EOL;
}