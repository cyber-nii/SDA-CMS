<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record New Baptism') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('baptisms.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="member_search" :value="__('Member')" />
                            
                            <!-- Simplified Searchable Member Selection -->
                            <div x-data="{
                                open: false,
                                search: '',
                                selectedId: '{{ old('member_id') }}',
                                selectedName: '',
                                items: [
                                    @foreach($members as $member)
                                        { id: '{{ $member->member_id }}', name: '{{ addslashes($member->first_name) }} {{ addslashes($member->last_name) }} ({{ $member->member_id }})' },
                                    @endforeach
                                ],
                                init() {
                                    if(this.selectedId) {
                                        let item = this.items.find(i => i.id == this.selectedId);
                                        if(item) {
                                            this.selectedName = item.name;
                                            this.search = item.name;
                                        }
                                    }
                                },
                                get filteredItems() {
                                    if (this.search === '' || this.search === this.selectedName) return [];
                                    return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase())).slice(0, 50);
                                },
                                selectItem(item) {
                                    this.selectedId = item.id;
                                    this.selectedName = item.name;
                                    this.search = item.name;
                                    this.open = false;
                                }
                            }" class="relative mt-1">
                                <input type="hidden" name="member_id" :value="selectedId">
                                
                                <div class="relative">
                                    <input type="text" 
                                        x-model="search" 
                                        @input="open = true; if(!search) selectedId = ''"
                                        @focus="open = true"
                                        @keydown.escape="open = false"
                                        placeholder="Search member by name or ID..."
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                        autocomplete="off">
                                    
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                </div>

                                <div x-show="open && filteredItems.length > 0" 
                                    @click.away="open = false"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-xl max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                    style="display: none;">
                                    
                                    <ul class="max-h-56 overflow-y-auto" role="listbox">
                                        <template x-for="item in filteredItems" :key="item.id">
                                            <li @click="selectItem(item)"
                                                class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-primary-600 hover:text-white transition"
                                                role="option">
                                                <span class="block truncate" x-text="item.name"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="baptism_date" :value="__('Baptism Date')" />
                                <x-text-input id="baptism_date" class="block mt-1 w-full" type="date" name="baptism_date" :value="old('baptism_date')" required />
                                <x-input-error :messages="$errors->get('baptism_date')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="pastor_name" :value="__('Officiating Pastor')" />
                                <x-text-input id="pastor_name" class="block mt-1 w-full" type="text" name="pastor_name" :value="old('pastor_name')" required placeholder="Pastor's Full Name" />
                                <x-input-error :messages="$errors->get('pastor_name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="e.g., Church Baptistery, Beach, etc." />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('Notes (Optional)')" />
                            <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" rows="3">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('baptisms.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Save Record') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
