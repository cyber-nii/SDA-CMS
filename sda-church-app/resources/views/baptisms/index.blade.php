<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Baptism Records') }}
            </h2>
            <div class="flex items-center gap-3">
                <x-export-dropdown :routes="[
                    'csv' => route('baptisms.export', array_merge(request()->query(), ['format' => 'csv'])),
                    'pdf' => route('baptisms.export', array_merge(request()->query(), ['format' => 'pdf']))
                ]" />
                <a href="{{ route('baptisms.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition-all duration-300 shadow-sm hover:shadow-lg active:scale-95">
                    + Add Baptism
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfd] min-h-screen relative overflow-hidden" x-data="{ deleteUrl: '', deleteName: '' }">
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-primary-50/40 to-transparent pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            @if(session('success'))
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

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-primary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-primary-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-primary-500 mr-2 animate-pulse"></span>
                            Total Baptisms
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ \App\Models\Baptism::count() }}</p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-secondary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-secondary-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-secondary-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-secondary-400 mr-2"></span>
                            This Year
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ \App\Models\Baptism::whereYear('baptism_date', now()->year)->count() }}</p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-gray-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-neutral-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-neutral-500 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-neutral-400 mr-2"></span>
                            Latest
                        </h2>
                        @php $latest = \App\Models\Baptism::latest('baptism_date')->first(); @endphp
                        <p class="text-2xl font-black text-gray-900 tracking-tight">
                            {{ $latest ? \Carbon\Carbon::parse($latest->baptism_date)->format('M d, Y') : '—' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Records Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Table Header -->
                <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="font-black text-xl text-gray-900 tracking-tight flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary-600 mr-2.5"></span>
                        Baptism Records
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Member</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Officiating Pastor</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Location</th>
                                <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse($baptisms as $baptism)
                                <tr class="hover:bg-primary-50/40 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($baptism->baptism_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $baptism->member->first_name }} {{ $baptism->member->last_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $baptism->pastor_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($baptism->location)
                                            <span class="text-xs font-medium bg-primary-50 text-primary-700 px-2.5 py-1 rounded-md">{{ $baptism->location }}</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('baptisms.edit', $baptism->baptism_id) }}"
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 transition">
                                                Edit
                                            </a>
                                            <button type="button"
                                                @click="deleteUrl = '{{ route('baptisms.destroy', $baptism->baptism_id) }}'; deleteName = '{{ addslashes($baptism->member->first_name . ' ' . $baptism->member->last_name) }}'; $dispatch('open-modal', 'confirm-delete')"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <p class="text-sm text-gray-400 font-medium">No baptism records found.</p>
                                        <p class="text-xs text-gray-300 mt-1">Add the first baptism record using the button above.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($baptisms->hasPages())
                    <div class="px-6 py-4 border-t border-gray-50">
                        {{ $baptisms->links() }}
                    </div>
                @endif
            </div>

        </div>

        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-6">
                <h2 class="text-lg font-black text-gray-800">Delete baptism record?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    The baptism record for <strong x-text="deleteName"></strong> will be permanently deleted.
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
