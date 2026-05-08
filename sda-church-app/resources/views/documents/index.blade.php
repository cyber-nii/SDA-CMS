<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                {{ __('Document Library') }}
            </h2>
            <div class="flex items-center gap-3">
                <x-export-dropdown :routes="['zip' => route('documents.bulk-download', request()->query())]" />
                <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition-all duration-300 shadow-sm hover:shadow-lg active:scale-95">
                    + Upload Document
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfd] min-h-screen relative overflow-hidden" x-data="{ deleteUrl: '', deleteName: '' }">
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-primary-50/40 to-transparent pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="bg-primary-50 border-l-4 border-primary-600 text-primary-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-primary-600 hover:text-primary-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between" role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <!-- Search + Filter Bar -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5 flex flex-wrap gap-3 items-center justify-between">
                <form method="GET" action="{{ route('documents.index') }}" class="flex gap-2 flex-1 max-w-lg">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search documents by title or description…"
                        class="flex-1 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-3">
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all active:scale-95 shadow-sm">
                        Search
                    </button>
                    @if($search)
                        <a href="{{ route('documents.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">
                            Clear
                        </a>
                    @endif
                </form>
                <p class="text-xs text-gray-400 font-medium">{{ $documents->total() }} {{ Str::plural('document', $documents->total()) }}</p>
            </div>

            <!-- Documents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documents as $document)
                    @php
                        $typeConfig = match($document->document_type) {
                            'Minutes'  => ['icon_bg' => 'bg-primary-50',   'icon_text' => 'text-primary-600',   'badge' => 'bg-primary-50 text-primary-700'],
                            'Policy'   => ['icon_bg' => 'bg-secondary-50', 'icon_text' => 'text-secondary-600', 'badge' => 'bg-secondary-50 text-secondary-700'],
                            'Report'   => ['icon_bg' => 'bg-neutral-100',  'icon_text' => 'text-neutral-600',   'badge' => 'bg-neutral-100 text-neutral-700'],
                            'Form'     => ['icon_bg' => 'bg-red-50',       'icon_text' => 'text-red-600',       'badge' => 'bg-red-50 text-red-700'],
                            default    => ['icon_bg' => 'bg-gray-100',     'icon_text' => 'text-gray-500',      'badge' => 'bg-gray-100 text-gray-600'],
                        };
                    @endphp
                    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:shadow-primary-900/10 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 rounded-2xl {{ $typeConfig['icon_bg'] }} {{ $typeConfig['icon_text'] }}">
                                @if($document->document_type === 'Minutes')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($document->document_type === 'Policy')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                @elseif($document->document_type === 'Report')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                @elseif($document->document_type === 'Form')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-lg {{ $typeConfig['badge'] }}">
                                {{ $document->document_type }}
                            </span>
                        </div>

                        <h3 class="text-base font-black text-gray-900 mb-1.5 truncate tracking-tight" title="{{ $document->title }}">{{ $document->title }}</h3>
                        <p class="text-sm text-gray-400 mb-4 line-clamp-2">{{ $document->description ?? 'No description provided.' }}</p>

                        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                            <div class="text-xs text-gray-400 leading-relaxed">
                                <p class="font-medium text-gray-500">{{ $document->uploader->first_name ?? 'Unknown' }}</p>
                                <p>{{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('documents.show', $document) }}" title="Download"
                                   class="text-primary-500 hover:text-primary-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                                @if(in_array(auth()->user()?->role, ['Super Admin', 'Pastor']))
                                    <a href="{{ route('documents.edit', $document) }}" title="Edit"
                                       class="text-secondary-500 hover:text-secondary-700 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button type="button" title="Delete"
                                        @click="deleteUrl = '{{ route('documents.destroy', $document) }}'; deleteName = '{{ addslashes($document->title) }}'; $dispatch('open-modal', 'confirm-delete')"
                                        class="text-red-400 hover:text-red-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-sm font-medium text-gray-400">No documents found.</p>
                        <p class="text-xs text-gray-300 mt-1 mb-6">Get started by uploading a new document.</p>
                        <a href="{{ route('documents.create') }}" class="inline-flex items-center px-5 py-2.5 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all shadow-sm">
                            + Upload Document
                        </a>
                    </div>
                @endforelse
            </div>

            @if($documents->hasPages())
                <div>{{ $documents->links() }}</div>
            @endif

        </div>

        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-6">
                <h2 class="text-lg font-black text-gray-800">Delete document?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    "<span x-text="deleteName"></span>" will be permanently deleted.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal', 'confirm-delete')"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
