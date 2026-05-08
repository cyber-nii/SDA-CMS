<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Members Directory') }}
            </h2>
        <div class="flex items-center gap-4">
            <x-export-dropdown :routes="[
                'csv' => route('members.export', array_merge(request()->query(), ['format' => 'csv'])),
                'pdf' => route('members.export', array_merge(request()->query(), ['format' => 'pdf']))
            ]" />
            <x-button href="{{ route('members.create') }}" variant="primary" size="sm">
                + Register New Member
            </x-button>
        </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="{ deleteUrl: '', deleteName: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative shadow-sm flex items-center justify-between"
                     role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-4 text-green-500 hover:text-green-700" aria-label="Dismiss">
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <!-- Search bar in card header -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-4 bg-white/50 backdrop-blur-sm">
                    <form method="GET" action="{{ route('members.index') }}" class="flex w-full max-w-md relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search members by name, email, or contact..." class="form-input rounded-l-lg border-neutral-300 w-full focus:ring focus:ring-primary-200 focus:ring-opacity-50 py-2.5 pl-10 pr-3 shadow-sm border focus:border-primary-500 transition-all duration-300 hover:border-neutral-400 bg-gray-50 focus:bg-white">
                        <button type="submit" class="bg-primary-50 px-6 py-2.5 rounded-r-lg border border-l-0 border-primary-200 text-primary-700 hover:bg-primary-600 hover:text-white transition-all duration-300 font-bold shadow-sm active:scale-95">Search</button>
                        @if($search)
                            <a href="{{ route('members.index') }}" class="ml-3 self-center text-sm font-medium text-gray-500 hover:text-red-600 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($members as $member)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap outline-none">
                                        <div class="flex items-center group">
                                            <div class="flex-shrink-0 w-10 h-10 transform transition-transform duration-300 group-hover:scale-110">
                                                @if($member->profile_picture)
                                                    <img src="{{ asset('storage/' . $member->profile_picture) }}" alt="Profile" class="w-full h-full rounded-full object-cover border-2 border-transparent group-hover:border-primary-200 shadow-sm transition-all">
                                                @else
                                                    <div class="w-full h-full rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold uppercase text-xs border-2 border-transparent group-hover:border-primary-200 shadow-sm transition-all">
                                                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 group-hover:text-primary-700 transition-colors">{{ $member->first_name }} {{ $member->last_name }}</div>
                                                <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-300 mr-1.5"></span>
                                                    {{ $member->gender }} &middot; {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->age . ' yrs' : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $member->email ?? 'No Email' }}</div>
                                        <div class="text-sm text-gray-500">{{ $member->contact_number ?? 'No Phone' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge :status="$member->status">{{ $member->status }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('members.show', $member->member_id) }}"
                                               class="inline-flex items-center p-2 text-xs font-medium rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-600 hover:text-white transition-all shadow-sm" title="View Member">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('members.edit', $member->member_id) }}"
                                               class="inline-flex items-center p-2 text-xs font-medium rounded-lg bg-neutral-100 text-neutral-700 hover:bg-neutral-800 hover:text-white transition-all shadow-sm" title="Edit Member">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <button type="button"
                                                aria-label="Delete {{ $member->first_name }} {{ $member->last_name }}"
                                                title="Delete Member"
                                                @click="deleteUrl = '{{ route('members.destroy', $member->member_id) }}'; deleteName = '{{ addslashes($member->first_name . ' ' . $member->last_name) }}'; $dispatch('open-modal', 'confirm-delete')"
                                                class="inline-flex items-center p-2 text-xs font-medium rounded-lg bg-red-50 text-red-700 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center italic">
                                        No members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $members->links() }}
                </div>
            </div>

        </div>

        {{-- Single delete confirmation modal for the whole page --}}
        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-800">Remove member?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    <span x-text="deleteName"></span> will be permanently removed. This cannot be undone.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button @click="$dispatch('close-modal', 'confirm-delete')">
                        Cancel
                    </x-secondary-button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <x-danger-button type="submit">
                            Delete
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>
