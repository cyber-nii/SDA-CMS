<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transfer Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transfers.update', $transfer->transfer_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="member_id" :value="__('Member')" />
                            <select id="member_id" name="member_id" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                <option value="">Select Member</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->member_id }}" {{ old('member_id', $transfer->member_id) == $member->member_id ? 'selected' : '' }}>
                                        {{ $member->first_name }} {{ $member->last_name }} ({{ $member->member_id }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="transfer_type" :value="__('Transfer Type')" />
                                <select id="transfer_type" name="transfer_type" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="In" {{ old('transfer_type', $transfer->transfer_type) == 'In' ? 'selected' : '' }}>Transfer In (Joining)</option>
                                    <option value="Out" {{ old('transfer_type', $transfer->transfer_type) == 'Out' ? 'selected' : '' }}>Transfer Out (Leaving)</option>
                                </select>
                                <x-input-error :messages="$errors->get('transfer_type')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="Pending" {{ old('status', $transfer->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ old('status', $transfer->status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Completed" {{ old('status', $transfer->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Rejected" {{ old('status', $transfer->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="from_church" :value="__('From Church')" />
                                <x-text-input id="from_church" class="block mt-1 w-full" type="text" name="from_church" :value="old('from_church', $transfer->from_church)" />
                                <x-input-error :messages="$errors->get('from_church')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="to_church" :value="__('To Church')" />
                                <x-text-input id="to_church" class="block mt-1 w-full" type="text" name="to_church" :value="old('to_church', $transfer->to_church)" />
                                <x-input-error :messages="$errors->get('to_church')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="request_date" :value="__('Request Date')" />
                                <x-text-input id="request_date" class="block mt-1 w-full" type="date" name="request_date" :value="old('request_date', $transfer->request_date)" required />
                                <x-input-error :messages="$errors->get('request_date')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="approval_date" :value="__('Approval Date (Optional)')" />
                                <x-text-input id="approval_date" class="block mt-1 w-full" type="date" name="approval_date" :value="old('approval_date', $transfer->approval_date)" />
                                <x-input-error :messages="$errors->get('approval_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('Notes (Optional)')" />
                            <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" rows="3">{{ old('notes', $transfer->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('transfers.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Transfer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
