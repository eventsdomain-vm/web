<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Team Member</h2>
            <a href="{{ route('organizer.events.team.index', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Team</a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <form action="{{ route('organizer.events.team.store', $event) }}" method="POST" class="card p-6 md:p-8 space-y-6">
            @csrf

            <div class="input-group">
                <label class="label">Select User <span class="text-red-500">*</span></label>
                <select name="user_id" class="input-field input-lg" required>
                    <option value="">Select a user...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('user_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="input-group">
                <label class="label">Role <span class="text-red-500">*</span></label>
                <input type="text" name="role" value="{{ old('role') }}" class="input-field input-lg" required placeholder="e.g., Co-Organizer, Volunteer, Speaker Coordinator">
                @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('organizer.events.team.index', $event) }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Add Member</button>
            </div>
        </form>
    </div>
</x-app-layout>
