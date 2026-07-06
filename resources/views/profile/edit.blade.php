<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-6 mb-6">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 rounded-full object-cover">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-500">{{ auth()->user()->email }}</p>
                        <span class="badge badge-info capitalize mt-2">{{ auth()->user()->role_name ?? 'User' }}</span>
                    </div>
                </div>

                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                @include('profile.partials.update-password-form')
            </div>

            <!-- GST Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                @include('profile.partials.update-gst-form')
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
