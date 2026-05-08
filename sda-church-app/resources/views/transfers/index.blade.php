<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Member Transfers') }}
            </h2>
            <div class="flex items-center gap-3">
                <x-export-dropdown :routes="[
                    'csv' => route('transfers.export', array_merge(request()->query(), ['format' => 'csv'])),
                    'pdf' => route('transfers.export', array_merge(request()->query(), ['format' => 'pdf']))
                ]" />
                <a href="{{ route('transfers.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition-all duration-300 shadow-sm hover:shadow-lg active:scale-95">
                    + New Transfer
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
                            Total Transfers
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ \App\Models\Transfer::count() }}</p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-secondary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-secondary-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-secondary-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-secondary-400 mr-2"></span>
                            Transfers In
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ \App\Models\Transfer::where('transfer_type', 'In')->count() }}</p>
                    </div>
                </div>

                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-gray-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-neutral-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-neutral-500 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-neutral-400 mr-2"></span>
                            Transfers Out
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ \App\Models\Transfer::where('transfer_type', 'Out')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Records Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="font-black text-xl text-gray-900 tracking-tight flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary-600 mr-2.5"></span>
                        Transfer Records
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Member</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Type</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Church</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse($transfers as $transfer)
                                <tr class="hover:bg-primary-50/40 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($transfer->request_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $transfer->member->first_name }} {{ $transfer->member->last_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($transfer->transfer_type === 'In')
                                            <span class="text-xs font-bold bg-primary-50 text-primary-700 px-2.5 py-1 rounded-md">↓ In</span>
                                        @else
                                            <span class="text-xs font-bold bg-neutral-100 text-neutral-600 px-2.5 py-1 rounded-md">↑ Out</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transfer->transfer_type === 'In' ? $transfer->from_church : $transfer->to_church }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $statusClass = match($transfer->status) {
                                                'Approved'  => 'bg-primary-50 text-primary-700',
                                                'Completed' => 'bg-primary-100 text-primary-800',
                                                'Rejected'  => 'bg-red-50 text-red-700',
                                                default     => 'bg-secondary-50 text-secondary-700',
                                            };
                                        @endphp
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-md {{ $statusClass }}">{{ $transfer->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('transfers.edit', $transfer->transfer_id) }}"
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 transition">
                                                Edit
                                            </a>
                                            <button type="button"
                                                @click="deleteUrl = '{{ route('transfers.destroy', $transfer->transfer_id) }}'; deleteName = '{{ addslashes($transfer->member->first_name . ' ' . $transfer->member->last_name) }}'; $dispatch('open-modal', 'confirm-delete')"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        <p class="text-sm text-gray-400 font-medium">No transfer records found.</p>
                                        <p class="text-xs text-gray-300 mt-1">Add the first transfer using the button above.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transfers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-50">
                        {{ $transfers->links() }}
                    </div>
                @endif
            </div>

        </div>

        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-6">
                <h2 class="text-lg font-black text-gray-800">Delete transfer record?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    The transfer record for <strong x-text="deleteName"></strong> will be permanently deleted.
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
