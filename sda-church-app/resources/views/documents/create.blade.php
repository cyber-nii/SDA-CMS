<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('documents.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Upload Document') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-8">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">
                        <!-- Document Title -->
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Document Title <span class="text-red-500">*</span></label>
                            <input id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" type="text" name="title" value="{{ old('title') }}" required autofocus />
                        </div>

                        <!-- Document Type -->
                        <div>
                            <label for="document_type" class="block font-medium text-sm text-gray-700">Document Type <span class="text-red-500">*</span></label>
                            <select id="document_type" name="document_type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="Minutes" {{ old('document_type') == 'Minutes' ? 'selected' : '' }}>Meeting Minutes</option>
                                <option value="Policy" {{ old('document_type') == 'Policy' ? 'selected' : '' }}>Church Policy / Guidelines</option>
                                <option value="Form" {{ old('document_type') == 'Form' ? 'selected' : '' }}>Standard Form</option>
                                <option value="Report" {{ old('document_type') == 'Report' ? 'selected' : '' }}>Departmental Report</option>
                                <option value="Other" {{ old('document_type') == 'Other' ? 'selected' : '' }}>Other Documents</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description (Optional)</label>
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Provide a brief summary of what this document contains.</p>
                        </div>

                        <!-- File Upload -->
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Select File <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition bg-gray-50">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500 p-1">
                                            <span>Upload a file</span>
                                            <input id="file" name="file" type="file" class="sr-only" required>
                                        </label>
                                        <p class="pl-1 pt-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">PDF, DOC, DOCX, XLS, XLSX up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('documents.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button class="bg-primary-600 hover:bg-primary-700 shadow-sm border-none">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                {{ __('Upload Document') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
