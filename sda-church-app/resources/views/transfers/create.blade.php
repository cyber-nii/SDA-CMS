<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('transfers.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('New Transfer Request') }}</h2>
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
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Transfer Details
                </h3>

                <form action="{{ route('transfers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Member <span class="text-red-500">*</span></label>
                        <select name="member_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors text-sm py-3" required>
                            <option value="">— Select Member —</option>
                            @foreach($members as $member)
                                <option value="{{ $member->member_id }}" {{ old('member_id') == $member->member_id ? 'selected' : '' }}>
                                    {{ $member->first_name }} {{ $member->last_name }} ({{ $member->member_id }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Transfer Type <span class="text-red-500">*</span></label>
                            <select name="transfer_type" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors text-sm py-3" required>
                                <option value="In" {{ old('transfer_type') == 'In' ? 'selected' : '' }}>Transfer In (Joining)</option>
                                <option value="Out" {{ old('transfer_type') == 'Out' ? 'selected' : '' }}>Transfer Out (Leaving)</option>
                            </select>
                            <x-input-error :messages="$errors->get('transfer_type')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status <span class="text-red-500">*</span></label>
                            <select name="status" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors text-sm py-3" required>
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Completed" {{ old('status', 'Completed') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">From Church</label>
                            <input type="text" name="from_church" value="{{ old('from_church') }}" placeholder="Current Church"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3">
                            <x-input-error :messages="$errors->get('from_church')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">To Church</label>
                            <input type="text" name="to_church" value="{{ old('to_church') }}" placeholder="Destination Church"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3">
                            <x-input-error :messages="$errors->get('to_church')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Request Date <span class="text-red-500">*</span></label>
                            <input type="date" name="request_date" value="{{ old('request_date', date('Y-m-d')) }}"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" required>
                            <x-input-error :messages="$errors->get('request_date')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Approval Date</label>
                            <input type="date" name="approval_date" value="{{ old('approval_date') }}"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3">
                            <x-input-error :messages="$errors->get('approval_date')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Notes (Optional)</label>
                        <textarea name="notes" rows="3"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-50">
                        <a href="{{ route('transfers.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="flex items-center px-6 py-2.5 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all hover:shadow-lg active:scale-95 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Record Transfer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
