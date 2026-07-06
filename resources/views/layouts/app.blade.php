<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'EventsDomain - Your Event Dashboard')">
    <title>@yield('title', config('app.name', 'EventsDomain')) - Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @include('partials.tracking-head')
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50/50">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.navigation')

        <div class="flex flex-col flex-1 min-w-0 lg:pl-[280px] transition-all duration-300 ease-in-out">
            {{-- Global Dashboard Header --}}
            <x-layout.dashboard-header />

            {{-- Optional page-specific header --}}
            @if(isset($header))
            <div class="bg-white border-b border-gray-100 px-6 py-3 shrink-0">
                {{ $header }}
            </div>
            @endif

            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
