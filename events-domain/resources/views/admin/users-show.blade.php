<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- User Info -->
            <div class="card p-6 mb-6">
                <div class="flex items-center gap-6">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="badge badge-info capitalize">{{ $user->role_name ?? 'User' }}</span>
                            @if($user->hasVerifiedEmail())
                                <span class="badge badge-success">Email Verified</span>
                            @else
                                <span class="badge badge-warning">Email Pending</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Info -->
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Company Name</p>
                            <p class="font-medium">{{ $user->profile->company_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium">{{ $user->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium">{{ $user->profile->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="font-medium">{{ $user->profile->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Member Since</p>
                            <p class="font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Updated</p>
                            <p class="font-medium">{{ $user->updated_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Profile Status</p>
                            <p class="font-medium {{ $user->isProfileComplete() ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $user->isProfileComplete() ? 'Complete' : 'Incomplete' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
