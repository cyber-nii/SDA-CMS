<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('documents.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Edit Document Information') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfd] min-h-screen relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-primary-50/40 to-transparent pointer-events-none"></div>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 relative z-10">

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm">
                    <strong class="font-bold">Please check your inputs:</strong>
                    <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-600 via-primary-400 to-secondary-400"></div>

                <h3 class="font-black text-xl text-gray-900 mb-2 tracking-tight flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Document
                </h3>
                <p class="text-xs text-gray-400 mb-8">Note: re-uploading a file is not supported. Edit title and description only.</p>

                <form action="{{ route('documents.update', $document->document_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $document->title) }}" autofocus
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" required>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm">{{ old('description', $document->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-50">
                        <a href="{{ route('documents.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="flex items-center px-6 py-2.5 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all hover:shadow-lg active:scale-95 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Update Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
