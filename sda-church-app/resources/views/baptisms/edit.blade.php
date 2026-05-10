<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('baptisms.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Edit Baptism Record') }}</h2>
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
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Baptism Details
                </h3>

                <form action="{{ route('baptisms.update', $baptism->baptism_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Member Search -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Member <span class="text-red-500">*</span></label>
                        <div x-data="{
                            open: false,
                            search: '',
                            selectedId: '{{ old('member_id', $baptism->member_id) }}',
                            selectedName: '',
                            items: [
                                @foreach($members as $member)
                                    { id: '{{ $member->member_id }}', name: '{{ addslashes($member->first_name) }} {{ addslashes($member->last_name) }}' },
                                @endforeach
                            ],
                            init() {
                                if(this.selectedId) {
                                    let item = this.items.find(i => i.id == this.selectedId);
                                    if(item) { this.selectedName = item.name; this.search = item.name; }
                                }
                            },
                            get filteredItems() {
                                if (this.search === '' || this.search === this.selectedName) return [];
                                return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase())).slice(0, 50);
                            },
                            selectItem(item) {
                                this.selectedId = item.id; this.selectedName = item.name;
                                this.search = item.name; this.open = false;
                            }
                        }" class="relative">
                            <input type="hidden" name="member_id" :value="selectedId">
                            <div class="relative">
                                <input type="text" x-model="search"
                                    @input="open = true; if(!search) selectedId = ''"
                                    @focus="open = true"
                                    @keydown.escape="open = false"
                                    placeholder="Search member by name or ID…"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors text-sm py-3 pr-10"
                                    autocomplete="off">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                            <div x-show="open && filteredItems.length > 0" @click.away="open = false"
                                class="absolute z-10 mt-1 w-full bg-white shadow-xl rounded-xl border border-gray-100 overflow-hidden" style="display:none;">
                                <ul class="max-h-56 overflow-y-auto divide-y divide-gray-50" role="listbox">
                                    <template x-for="item in filteredItems" :key="item.id">
                                        <li @click="selectItem(item)"
                                            class="px-4 py-2.5 text-sm text-gray-700 cursor-pointer hover:bg-primary-50 hover:text-primary-800 transition"
                                            role="option">
                                            <span class="block truncate" x-text="item.name"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Baptism Date <span class="text-red-500">*</span></label>
                            <input type="date" name="baptism_date" value="{{ old('baptism_date', $baptism->baptism_date) }}"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" required>
                            <x-input-error :messages="$errors->get('baptism_date')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Officiating Pastor <span class="text-red-500">*</span></label>
                            <input type="text" name="pastor_name" value="{{ old('pastor_name', $baptism->pastor_name) }}"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" required>
                            <x-input-error :messages="$errors->get('pastor_name')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Location</label>
                        <input type="text" name="location" value="{{ old('location', $baptism->location) }}"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3">
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Notes</label>
                        <textarea name="notes" rows="3"
                            class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm">{{ old('notes', $baptism->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-50">
                        <a href="{{ route('baptisms.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="flex items-center px-6 py-2.5 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all hover:shadow-lg active:scale-95 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
