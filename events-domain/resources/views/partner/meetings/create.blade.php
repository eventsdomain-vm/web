<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.meetings.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Schedule Meeting</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <form method="POST" action="{{ route('partner.meetings.store') }}" class="card p-6 max-w-2xl">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" class="w-full rounded-lg border-gray-300 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="online">Online</option>
                        <option value="phone">Phone</option>
                        <option value="in-person">In-Person</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Link</label>
                    <input type="url" name="meeting_link" class="w-full rounded-lg border-gray-300 text-sm" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="datetime-local" name="start_time" class="w-full rounded-lg border-gray-300 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="datetime-local" name="end_time" class="w-full rounded-lg border-gray-300 text-sm" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-sm">Schedule</button>
            </div>
        </form>
    </div>
</x-app-layout>
