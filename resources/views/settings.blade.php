<x-app-layout>
    <x-slot name="title">Settings - EventsDomain</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Settings</h1>

            <div class="card p-6">
                <h2 class="heading-3 mb-4">Account Settings</h2>
                <p class="text-gray-500 mb-6">Manage your account preferences and notification settings.</p>
                <a href="{{ route('profile.edit') }}" class="btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</x-app-layout>
