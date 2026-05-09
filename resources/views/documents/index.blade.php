<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                {{ __('Document Library') }}
            </h2>
            <div class="flex items-center gap-4">
                <x-export-dropdown :routes="['zip' => route('documents.bulk-download', request()->query())]" />
                <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-900 focus:outline-none focus:border-primary-900 focus:ring ring-primary-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                    + Upload Document
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="{ deleteUrl: '', deleteName: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-4 text-green-500 hover:text-green-700" aria-label="Dismiss">
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-4 text-red-500 hover:text-red-700" aria-label="Dismiss">
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6 mb-6 flex justify-between items-center">
                <form method="GET" action="{{ route('documents.index') }}" class="flex w-full max-w-lg">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search documents by title or description..." class="form-input rounded-l-md border-gray-300 w-full focus:ring-primary-500 py-2 px-3 shadow-sm border focus:border-primary-500">
                    <button type="submit" class="bg-primary-50 px-4 py-2 rounded-r-md border border-l-0 border-gray-300 text-primary-700 hover:bg-primary-100 transition font-medium">Search</button>
                    @if($search)
                        <a href="{{ route('documents.index') }}" class="ml-2 mt-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                    @endif
                </form>
            </div>

            <!-- Documents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documents as $document)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 rounded-lg 
                                {{ $document->document_type === 'Minutes' ? 'bg-blue-100 text-blue-600' : '' }}
                                {{ $document->document_type === 'Policy' ? 'bg-purple-100 text-purple-600' : '' }}
                                {{ $document->document_type === 'Form' ? 'bg-orange-100 text-orange-600' : '' }}
                                {{ $document->document_type === 'Report' ? 'bg-teal-100 text-teal-600' : '' }}
                                {{ $document->document_type === 'Other' ? 'bg-gray-100 text-gray-600' : '' }}
                            ">
                                @if($document->document_type === 'Minutes')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($document->document_type === 'Policy')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $document->document_type }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-2 truncate" title="{{ $document->title }}">{{ $document->title }}</h3>
                        <p class="text-sm text-gray-500 mb-4 h-10 overflow-hidden">{{ $document->description ?? 'No description provided.' }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="text-xs text-gray-400">
                                <p>By: {{ $document->uploader->first_name ?? 'Unknown' }}</p>
                                <p>{{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('documents.show', $document) }}" class="text-primary-600 hover:text-primary-900" title="Download">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                                @if(in_array(auth()->user()?->role, ['Super Admin', 'Pastor']))
                                <a href="{{ route('documents.edit', $document) }}" class="text-amber-600 hover:text-amber-900" title="Edit Info">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button type="button" title="Delete"
                                    @click="deleteUrl = '{{ route('documents.destroy', $document) }}'; deleteName = '{{ addslashes($document->title) }}'; $dispatch('open-modal', 'confirm-delete')"
                                    class="text-red-600 hover:text-red-900">
                                    <svg aria-hidden="true" class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No documents found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by uploading a new document.</p>
                        <div class="mt-6">
                            <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Upload Document
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $documents->links() }}
            </div>

        </div>

        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-800">Delete document?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    "<span x-text="deleteName"></span>" will be permanently deleted.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal', 'confirm-delete')"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
