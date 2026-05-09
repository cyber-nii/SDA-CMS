<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Member Transfers') }}
            </h2>
            <div class="flex items-center gap-4">
                <x-export-dropdown :routes="[
                    'csv' => route('transfers.export', array_merge(request()->query(), ['format' => 'csv'])),
                    'pdf' => route('transfers.export', array_merge(request()->query(), ['format' => 'pdf']))
                ]" />
                <a href="{{ route('transfers.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-900 focus:outline-none focus:border-primary-900 focus:ring ring-primary-300 disabled:opacity-25 transition ease-in-out duration-150">
                    New Transfer Request
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ deleteUrl: '', deleteName: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                             class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded flex items-center justify-between">
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                            <button @click="show = false" class="ml-4 text-green-500 hover:text-green-700" aria-label="Dismiss">
                                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Church</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($transfers as $transfer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($transfer->request_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $transfer->member->first_name }} {{ $transfer->member->last_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transfer->transfer_type === 'In' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $transfer->transfer_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transfer->transfer_type === 'In' ? $transfer->from_church : $transfer->to_church }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $statusColor = match($transfer->status) {
                                                    'Approved' => 'bg-green-100 text-green-800',
                                                    'Completed' => 'bg-emerald-100 text-emerald-800',
                                                    'Rejected' => 'bg-red-100 text-red-800',
                                                    default => 'bg-yellow-100 text-yellow-800',
                                                };
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                                {{ $transfer->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('transfers.edit', $transfer->transfer_id) }}"
                                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-primary-50 text-primary-700 hover:bg-primary-100 transition">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    @click="deleteUrl = '{{ route('transfers.destroy', $transfer->transfer_id) }}'; deleteName = '{{ addslashes($transfer->member->first_name . ' ' . $transfer->member->last_name) }}'; $dispatch('open-modal', 'confirm-delete')"
                                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No transfer records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transfers->links() }}
                    </div>
                </div>
            </div>
        </div>

        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-800">Delete transfer record?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    The transfer record for <span x-text="deleteName"></span> will be permanently deleted.
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
