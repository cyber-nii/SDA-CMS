<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Departments & Ministries') }}
            </h2>
            <div class="flex items-center gap-4">
                <x-export-dropdown :routes="[
        'csv' => route('departments.export', array_merge(request()->query(), ['format' => 'csv'])),
        'pdf' => route('departments.export', array_merge(request()->query(), ['format' => 'pdf']))
    ]" />
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfd] min-h-screen relative overflow-hidden">
        <!-- Subtle Background Decorative Elements -->
        <div
            class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-primary-50/30 to-transparent pointer-events-none">
        </div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-100/20 rounded-full blur-3xl pointer-events-none">
        </div>
        <div class="absolute top-1/2 -left-24 w-72 h-72 bg-gold-100/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    class="mb-8 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif

            @if ($departments->isEmpty())
                <div
                    class="bg-white/80 backdrop-blur-md rounded-3xl shadow-xl shadow-primary-900/5 border border-white p-16 text-center group">
                    <div
                        class="w-24 h-24 mx-auto bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl flex items-center justify-center mb-6 transform group-hover:rotate-12 transition-transform duration-500 shadow-inner">
                        <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3 tracking-tight">No Departments Yet</h3>
                    <p class="text-gray-500 max-w-sm mx-auto leading-relaxed">Your church ministries and departments will be
                        listed here. Contact your administrator to add new units.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($departments as $department)
                        <div
                            class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-primary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col h-full">
                            <!-- Animated Background Blob -->
                            <div
                                class="absolute -right-16 -top-16 w-48 h-48 bg-primary-50 rounded-full opacity-0 group-hover:opacity-40 group-hover:scale-110 transition-all duration-700 pointer-events-none">
                            </div>

                            <!-- Header: Icon & Name -->
                            <div class="relative z-10 flex items-start gap-5 mb-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white shadow-lg shadow-primary-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 flex-shrink-0">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h3
                                        class="text-xl font-extrabold text-gray-900 tracking-tight group-hover:text-primary-700 transition-colors duration-300 truncate">
                                        {{ $department->name }}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-primary-50 text-primary-600 uppercase tracking-tighter">Ministry
                                            Unit</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="relative z-10 flex-grow">
                                <p
                                    class="text-gray-500 text-sm leading-relaxed line-clamp-3 italic group-hover:text-gray-600 transition-colors">
                                    "{{ $department->description ?? 'Dedicated to serving the spiritual and social needs of our church community.' }}"
                                </p>
                            </div>

                            <!-- Footer Info -->
                            <div class="relative z-10 mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex -space-x-2">
                                        <div
                                            class="w-8 h-8 rounded-full border-2 border-white bg-primary-100 flex items-center justify-center text-primary-700 text-[10px] font-black shadow-sm">
                                            {{ $department->members_count }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Members</span>
                                        <span class="text-xs font-bold text-gray-700">{{ $department->members_count }}
                                            {{ Str::plural('Active', $department->members_count) }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('departments.show', $department) }}"
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 text-primary-600 hover:bg-primary-600 hover:text-white transition-all duration-300 shadow-sm group/btn hover:scale-110 active:scale-95"
                                    title="View Department Members">
                                    <svg class="w-5 h-5 transform group-hover/btn:translate-x-0.5 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>