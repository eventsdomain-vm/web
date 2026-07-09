<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="linkedin-domain-verification" content="2d2f2b43-b1ae-4cb8-8d61-d250c749e174">
    <meta name="description" content="{{ $meta_description ?? 'EventsDomain - India\'s B2B Event Sponsorship & Partnership Marketplace' }}">
    <title>{{ $title ?? config('app.name', 'EventsDomain') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    @include('partials.tracking-head')
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen flex flex-col">
        <x-public-header />

        <main class="flex-1 pt-16 lg:pt-18">
            {{ $slot }}
        </main>

        <x-public-footer />
    </div>
</body>
</html>
