<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('documents.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Upload Document') }}</h2>
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

                <h3 class="font-black text-xl text-gray-900 mb-8 tracking-tight flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Document Details
                </h3>

                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Document Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" autofocus
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Document Type <span class="text-red-500">*</span></label>
                        <select name="document_type" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors text-sm py-3" required>
                            <option value="" disabled selected>— Select a category —</option>
                            <option value="Minutes"  {{ old('document_type') == 'Minutes'  ? 'selected' : '' }}>Meeting Minutes</option>
                            <option value="Policy"   {{ old('document_type') == 'Policy'   ? 'selected' : '' }}>Church Policy / Guidelines</option>
                            <option value="Form"     {{ old('document_type') == 'Form'     ? 'selected' : '' }}>Standard Form</option>
                            <option value="Report"   {{ old('document_type') == 'Report'   ? 'selected' : '' }}>Departmental Report</option>
                            <option value="Other"    {{ old('document_type') == 'Other'    ? 'selected' : '' }}>Other Documents</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description (Optional)</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Provide a brief summary of what this document contains.</p>
                    </div>

                    <!-- File Upload Zone -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Select File <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-primary-200 border-dashed rounded-2xl bg-primary-50/30 hover:bg-primary-50/60 hover:border-primary-400 transition-colors cursor-pointer"
                             onclick="document.getElementById('file').click()">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-primary-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="text-sm font-bold text-primary-600">Click to upload a file</p>
                                <p class="text-xs text-gray-400">PDF, DOC, DOCX, XLS, XLSX — up to 10MB</p>
                                <input id="file" name="file" type="file" class="sr-only" required
                                       onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                                <p id="file-name" class="text-xs font-medium text-primary-700 mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-50">
                        <a href="{{ route('documents.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="flex items-center px-6 py-2.5 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all hover:shadow-lg active:scale-95 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Upload Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
