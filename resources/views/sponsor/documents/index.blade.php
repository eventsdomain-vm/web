<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Documents</h2>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="btn-primary text-sm">+ Upload Document</button>
        </div>
    </x-slot>
    <div class="container-page py-6">
        @forelse($documents as $document)
            <div class="card mb-3 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2"><h3 class="font-semibold text-gray-900">{{ $document->name }}</h3><span class="badge badge-{{ $document->status === 'final' ? 'success' : 'gray' }} text-xs">{{ ucfirst($document->status) }}</span></div>
                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                            <span>{{ ucfirst($document->type) }}</span>
                            <span>Uploaded by {{ $document->uploader->name }}</span>
                            <span>{{ $document->created_at->format('M d, Y') }}</span>
                            @if($document->versions->count())<span>{{ $document->versions->count() }} versions</span>@endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        @if($document->status === 'draft')
                            <form method="POST" action="{{ route('sponsor.documents.finalize', $document) }}">@csrf<button type="submit" class="btn-outline text-xs">Finalize</button></form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">No documents yet.</div>
        @endforelse
        {{ $documents->links() }}
    </div>
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Upload Document</h3>
            <form method="POST" action="{{ route('sponsor.documents.store') }}">@csrf
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" class="w-full border-gray-300 rounded-md" rows="2"></textarea></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Type</label><select name="type" class="w-full border-gray-300 rounded-md"><option value="proposal">Proposal</option><option value="contract">Contract</option><option value="report">Report</option><option value="creative">Creative</option><option value="legal">Legal</option><option value="other">Other</option></select></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">File Path / URL</label><input type="text" name="file_path" required class="w-full border-gray-300 rounded-md"></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Upload</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
