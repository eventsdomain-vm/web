<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Events</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_events']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Published Events</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['published_events']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-[#FFB0A1] bg-opacity-30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#E35336]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Sponsorships</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_sponsorships']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Reports --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('admin.reports.show', 'users') }}" class="card p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">User Report</h3>
                            <p class="text-sm text-gray-500">View user registrations and breakdowns</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.reports.show', 'events') }}" class="card p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Event Report</h3>
                            <p class="text-sm text-gray-500">View event listings and statuses</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.reports.show', 'sponsorships') }}" class="card p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Sponsorship Report</h3>
                            <p class="text-sm text-gray-500">View sponsorship requests and deals</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Recent Activity --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Recent Events --}}
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Recent Events</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentEvents as $event)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $event->organizer->name ?? 'N/A' }}</div>
                                    </div>
                                    <span class="badge badge-{{ $event->status_color }}">{{ $event->status_label }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                No recent events
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Users --}}
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Recent Users</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentUsers as $user)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    <span class="badge badge-info capitalize">{{ $user->role_name ?? 'User' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                No recent users
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
