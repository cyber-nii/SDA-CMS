<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Financial Management') }}
            </h2>
            <div class="flex items-center gap-5">
            
            @if(auth()->user()->role === 'Treasurer' || auth()->user()->role === 'Super Admin')
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <x-export-dropdown :routes="[
                        'csv' => route('finance.export', array_merge(request()->query(), ['format' => 'csv'])),
                        'pdf' => route('finance.export', array_merge(request()->query(), ['format' => 'pdf']))
                    ]" />
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-emerald-700 border border-transparent rounded-lg font-bold text-xs text-black uppercase tracking-widest hover:bg-gray-800 transition-all duration-300 shadow-sm hover:shadow-lg active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <!-- Custom Print Styles -->
    <style>
        @media print {
            @page { size: A4; margin: 20mm; }
            body { background: white !important; color: black !important; }
            nav, header, footer, .print\:hidden { display: none !important; }
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; background: transparent !important; }
            .bg-gray-50 { background-color: white !important; }
            .shadow-sm, .shadow-lg, .shadow-2xl { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
            table { border-collapse: collapse !important; width: 100% !important; margin-bottom: 2rem !important; }
            th, td { border: 1px solid #e5e7eb !important; padding: 0.5rem !important; }
            th:last-child, td:last-child { display: none !important; }
        }
    </style>

    <div class="py-12 bg-[#fcfdfd] min-h-screen print:min-h-0 relative overflow-hidden" x-data="{ deleteUrl: '', deleteTitle: '', activeForm: 'tithe' }">
        <!-- Subtle Background Decorative Elements -->
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-emerald-50/30 to-transparent pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            <!-- Print Header block (Only visible during print) -->
            <div class="hidden print:block text-center border-b-2 border-gray-800 pb-6 mb-8 mt-4">
                <h1 class="text-3xl font-black uppercase tracking-wider text-gray-900">SDA Church</h1>
                <h2 class="text-xl font-semibold text-gray-600 mt-1">Financial Summary Report</h2>
                <p class="text-sm text-gray-500 mt-2">Generated on: {{ now()->format('F j, Y - h:i A') }}</p>
                <p class="text-sm text-gray-500">Prepared by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm" role="alert">
                    <strong class="font-bold">Oops! Please check your inputs:</strong>
                    <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Finance Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Income -->
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-emerald-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                            Total Income
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">GHS {{ number_format($totalIncome, 2) }}</p>
                    </div>
                </div>

                <!-- Total Expenses -->
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-red-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-red-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                            Total Expenses
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">GHS {{ number_format($totalExpenses, 2) }}</p>
                    </div>
                </div>

                <!-- Net Balance -->
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-primary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-primary-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-primary-500 mr-2"></span>
                            Net Balance
                        </h2>
                        <p class="text-4xl font-black tracking-tight @if($netBalance < 0) text-red-600 @else text-primary-600 @endif">
                            GHS {{ number_format($netBalance, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 print:block">
                
                <!-- Left Column: Unified Operations Form -->
                <div class="xl:col-span-1 space-y-6 print:hidden">
                    <div class="bg-white rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 via-teal-400 to-blue-400"></div>
                        <h3 class="font-black text-xl text-gray-900 mb-6 tracking-tight flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Record Transaction
                        </h3>

                        <div>
                            <!-- Unified Tab Selector -->
                            <div class="flex flex-wrap gap-1 mb-6 bg-gray-50/80 p-1.5 rounded-xl border border-gray-100/80 backdrop-blur-sm">
                                <button @click="activeForm = 'tithe'" :class="activeForm === 'tithe' ? 'bg-white shadow-sm text-emerald-600 font-bold scale-100 ring-1 ring-gray-900/5' : 'text-gray-500 hover:text-gray-700 font-medium scale-95'" class="flex-1 py-2 text-xs uppercase tracking-wider rounded-lg transition-all duration-200">Tithe</button>
                                <button @click="activeForm = 'expenditure'" :class="activeForm === 'expenditure' ? 'bg-white shadow-sm text-red-600 font-bold scale-100 ring-1 ring-gray-900/5' : 'text-gray-500 hover:text-gray-700 font-medium scale-95'" class="flex-1 py-2 text-xs uppercase tracking-wider rounded-lg transition-all duration-200">Expense</button>
                                <button @click="activeForm = 'offering'" :class="activeForm === 'offering' ? 'bg-white shadow-sm text-teal-600 font-bold scale-100 ring-1 ring-gray-900/5' : 'text-gray-500 hover:text-gray-700 font-medium scale-95'" class="flex-1 py-2 text-xs uppercase tracking-wider rounded-lg transition-all duration-200">Offering</button>
                                <button @click="activeForm = 'donation'" :class="activeForm === 'donation' ? 'bg-white shadow-sm text-blue-600 font-bold scale-100 ring-1 ring-gray-900/5' : 'text-gray-500 hover:text-gray-700 font-medium scale-95'" class="flex-1 py-2 text-xs uppercase tracking-wider rounded-lg transition-all duration-200">Donate</button>
                            </div>

                            <!-- Tithe Form -->
                            <div x-show="activeForm === 'tithe'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <form method="POST" action="{{ route('finance.tithe.store') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Member <span class="text-red-500">*</span></label>
                                        <div x-data="{
                                            open: false,
                                            search: '',
                                            selectedId: '{{ old('member_id') }}',
                                            selectedName: '',
                                            items: [
                                                @foreach($members as $member)
                                                    { id: '{{ $member->member_id }}', name: '{{ addslashes($member->last_name) }}, {{ addslashes($member->first_name) }}' },
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
                                                    placeholder="Search member by name…"
                                                    class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors text-sm py-3 pr-10"
                                                    autocomplete="off" required>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                </div>
                                            </div>
                                            <div x-show="open && filteredItems.length > 0" @click.away="open = false"
                                                class="absolute z-50 mt-1 w-full bg-white shadow-xl rounded-xl border border-gray-100 overflow-hidden" style="display:none;">
                                                <ul class="max-h-56 overflow-y-auto divide-y divide-gray-50" role="listbox">
                                                    <template x-for="item in filteredItems" :key="item.id">
                                                        <li @click="selectItem(item)"
                                                            class="px-4 py-2.5 text-sm text-gray-700 cursor-pointer hover:bg-emerald-50 hover:text-emerald-800 transition"
                                                            role="option">
                                                            <span class="block truncate" x-text="item.name"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Amount (GHS)</label>
                                            <input type="number" step="0.01" name="amount" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors sm:text-sm py-3" placeholder="0.00" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date</label>
                                            <input type="date" name="date_received" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors sm:text-sm py-3" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all hover:shadow-lg active:scale-95 mt-6">
                                        Save Tithe
                                    </button>
                                </form>
                            </div>

                            <!-- Expenditure Form -->
                            <div x-show="activeForm === 'expenditure'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <form method="POST" action="{{ route('finance.expenditure.store') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Purpose / Title</label>
                                        <input type="text" name="title" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 text-sm py-3" placeholder="e.g. Utility Bill, Repair" required>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Category</label>
                                            <select name="category" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 text-sm py-3" required>
                                                @foreach($expenditureCategories as $cat)
                                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Method</label>
                                            <select name="payment_method" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 text-sm py-3" required>
                                                @foreach($paymentMethods as $method)
                                                    <option value="{{ $method }}">{{ $method }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Amount (GHS)</label>
                                            <input type="number" step="0.01" name="amount" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm py-3" placeholder="0.00" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date</label>
                                            <input type="date" name="expenditure_date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm py-3" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition-all hover:shadow-lg active:scale-95 mt-6">
                                        Save Expenditure
                                    </button>
                                </form>
                            </div>

                            <!-- Offering Form -->
                            <div x-show="activeForm === 'offering'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <form method="POST" action="{{ route('finance.offering.store') }}" class="space-y-4" x-data="{ mode: 'select', selectedCat: 'Divine Service', typedCat: '', get category() { return this.mode === 'select' ? this.selectedCat : this.typedCat; } }">
                                    @csrf
                                    <input type="hidden" name="category" :value="category">
                                    <div>
                                        <div class="flex justify-between items-center mb-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Offering Type</label>
                                            <div class="flex bg-gray-100 rounded-lg p-0.5">
                                                <button type="button" @click="mode = 'select'" :class="mode === 'select' ? 'bg-white shadow-sm text-teal-600' : 'text-gray-500'" class="px-2.5 py-1 text-[10px] font-bold rounded-md uppercase tracking-wider transition">Select</button>
                                                <button type="button" @click="mode = 'write'" :class="mode === 'write' ? 'bg-white shadow-sm text-teal-600' : 'text-gray-500'" class="px-2.5 py-1 text-[10px] font-bold rounded-md uppercase tracking-wider transition">Write</button>
                                            </div>
                                        </div>
                                        <div x-show="mode === 'select'">
                                            <select x-model="selectedCat" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-teal-500 focus:ring-teal-500 text-sm py-3">
                                                <option value="Divine Service">Divine Service</option>
                                                <option value="Sabbath School">Sabbath School</option>
                                                <option value="Camp Meeting">Camp Meeting</option>
                                                <option value="13th Sabbath">13th Sabbath</option>
                                                @foreach($existingOfferingCategories as $cat)
                                                    @if(!in_array($cat, ['Divine Service', 'Sabbath School', 'Camp Meeting', '13th Sabbath']))
                                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div x-show="mode === 'write'" x-cloak>
                                            <input type="text" x-model="typedCat" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-teal-500 focus:ring-teal-500 text-sm py-3" placeholder="e.g. Youth Offering">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Amount</label>
                                            <input type="number" step="0.01" name="amount" placeholder="0.00" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-teal-500 sm:text-sm py-3" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date</label>
                                            <input type="date" name="date_received" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-teal-500 sm:text-sm py-3" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 transition-all hover:shadow-lg active:scale-95 mt-6">
                                        Save Offering
                                    </button>
                                </form>
                            </div>

                            <!-- Donation Form -->
                            <div x-show="activeForm === 'donation'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <form method="POST" action="{{ route('finance.donation.store') }}" class="space-y-4" x-data="{ mode: 'select', selectedPurpose: 'Building Fund', typedPurpose: '', get purpose() { return this.mode === 'select' ? this.selectedPurpose : this.typedPurpose; } }">
                                    @csrf
                                    <input type="hidden" name="purpose" :value="purpose">
                                    <div>
                                        <div class="flex justify-between items-center mb-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Donation Purpose</label>
                                            <div class="flex bg-gray-100 rounded-lg p-0.5">
                                                <button type="button" @click="mode = 'select'" :class="mode === 'select' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="px-2.5 py-1 text-[10px] font-bold rounded-md uppercase tracking-wider transition">Select</button>
                                                <button type="button" @click="mode = 'write'" :class="mode === 'write' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'" class="px-2.5 py-1 text-[10px] font-bold rounded-md uppercase tracking-wider transition">Write</button>
                                            </div>
                                        </div>
                                        <div x-show="mode === 'select'">
                                            <select x-model="selectedPurpose" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm py-3">
                                                <option value="Building Fund">Building Fund</option>
                                                <option value="Mission Work">Mission Work</option>
                                                <option value="Welfare & Charity">Welfare & Charity</option>
                                                <option value="Youth Ministry">Youth Ministry</option>
                                                <option value="Music & Instruments">Music & Instruments</option>
                                                @foreach($existingDonationPurposes as $purpose)
                                                    @if(!in_array($purpose, ['Building Fund', 'Mission Work', 'Welfare & Charity', 'Youth Ministry', 'Music & Instruments']))
                                                        <option value="{{ $purpose }}">{{ $purpose }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div x-show="mode === 'write'" x-cloak>
                                            <input type="text" x-model="typedPurpose" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 text-sm py-3" placeholder="e.g. Disaster Relief">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Amount</label>
                                            <input type="number" step="0.01" name="amount" placeholder="0.00" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 sm:text-sm py-3" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date</label>
                                            <input type="date" name="date_received" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 sm:text-sm py-3" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all hover:shadow-lg active:scale-95 mt-6">
                                        Save Donation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Recent Records - synced to active tab -->
                <div class="xl:col-span-2 space-y-6 print:mt-8">

                    <!-- Recent Tithes -->
                    <div x-show="activeForm === 'tithe'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none break-inside-avoid">
                        <div class="flex justify-between items-center p-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2.5 animate-pulse"></span>
                                Recent Tithes
                            </h3>
                            <span class="text-[10px] bg-emerald-50 text-emerald-600 border border-emerald-100 px-2.5 py-1 rounded-md font-bold uppercase tracking-widest">Inflow</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Member</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest print:hidden">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    @forelse($tithes as $tithe)
                                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $tithe->date_received->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $tithe->member->first_name }} {{ $tithe->member->last_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-black text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">GHS {{ number_format($tithe->amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print:hidden">
                                                <button type="button" @click="deleteUrl = '{{ route('finance.tithe.destroy', $tithe->tithe_id) }}'; deleteTitle = 'Tithe — {{ addslashes($tithe->member->first_name . ' ' . $tithe->member->last_name) }}'; $dispatch('open-modal', 'confirm-delete')" class="text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all p-1 hover:bg-red-50 rounded">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No tithes recorded yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Expenditures -->
                    <div x-show="activeForm === 'expenditure'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none break-inside-avoid">
                        <div class="flex justify-between items-center p-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight">Recent Expenditures</h3>
                            <span class="text-[10px] bg-red-50 text-red-600 border border-red-100 px-2.5 py-1 rounded-md font-bold uppercase tracking-widest">Outflow</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Details</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest print:hidden">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    @forelse($expenditures as $exp)
                                        <tr class="hover:bg-red-50/30 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $exp->expenditure_date->format('M d, Y') }}</td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $exp->title }}</div>
                                                <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                                    {{ $exp->category }} • {{ $exp->payment_method }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-black text-red-600 bg-red-50 px-2.5 py-1 rounded-md">- GHS {{ number_format($exp->amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print:hidden">
                                                <button type="button" @click="deleteUrl = '{{ route('finance.expenditure.destroy', $exp->expenditure_id) }}'; deleteTitle = '{{ addslashes($exp->title) }}'; $dispatch('open-modal', 'confirm-delete')" class="text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all p-1 hover:bg-red-50 rounded">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No expenditures logged yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Offerings -->
                    <div x-show="activeForm === 'offering'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none break-inside-avoid">
                        <div class="flex justify-between items-center p-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center">
                                <span class="w-2.5 h-2.5 rounded-full bg-teal-500 mr-2.5"></span>
                                Recent Offerings
                            </h3>
                            <span class="text-[10px] bg-teal-50 text-teal-600 border border-teal-100 px-2.5 py-1 rounded-md font-bold uppercase tracking-widest">Inflow</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Category</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest print:hidden">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    @forelse($offerings as $off)
                                        <tr class="hover:bg-teal-50/30 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $off->date_received->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $off->category }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-black text-teal-600 bg-teal-50 px-2.5 py-1 rounded-md">GHS {{ number_format($off->amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print:hidden">
                                                <button type="button" @click="deleteUrl = '{{ route('finance.offering.destroy', $off->offering_id) }}'; deleteTitle = '{{ addslashes($off->category) }} Offering'; $dispatch('open-modal', 'confirm-delete')" class="text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all p-1 hover:bg-red-50 rounded">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No offerings recorded yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Donations -->
                    <div x-show="activeForm === 'donation'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none break-inside-avoid">
                        <div class="flex justify-between items-center p-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-2.5"></span>
                                Recent Donations
                            </h3>
                            <span class="text-[10px] bg-blue-50 text-blue-600 border border-blue-100 px-2.5 py-1 rounded-md font-bold uppercase tracking-widest">Inflow</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Purpose</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Donor</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest print:hidden">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    @forelse($donations as $don)
                                        <tr class="hover:bg-blue-50/30 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $don->date_received->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $don->purpose }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $don->member ? $don->member->first_name . ' ' . $don->member->last_name : '—' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-black text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">GHS {{ number_format($don->amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print:hidden">
                                                <button type="button" @click="deleteUrl = '{{ route('finance.donation.destroy', $don->donation_id) }}'; deleteTitle = '{{ addslashes($don->purpose) }} Donation'; $dispatch('open-modal', 'confirm-delete')" class="text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-all p-1 hover:bg-red-50 rounded">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400 italic">No donations recorded yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Funds Controller Records (always visible) -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none break-inside-avoid">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-50 bg-gray-50/30 gap-4">
                            <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Funds Controller
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="text-[10px] bg-primary-50 text-primary-700 border border-primary-100 px-2.5 py-1 rounded-md font-bold uppercase tracking-widest flex items-center shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500 mr-1.5"></span>
                                    Dept: GHS {{ number_format($totalDeptFunds, 2) }}
                                </span>
                                <span class="text-[10px] bg-amber-50 text-amber-700 border border-amber-100 px-2.5 py-1 rounded-md font-bold uppercase tracking-widest flex items-center shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                    Class: GHS {{ number_format($totalClassFunds, 2) }}
                                </span>
                            </div>
                        </div>

                        <div x-data="{ fundsTab: 'departments' }">
                            <div class="px-6 pt-4 pb-2 border-b border-gray-50">
                                <div class="flex gap-1 bg-gray-50/80 p-1 w-max rounded-lg border border-gray-100">
                                    <button @click="fundsTab = 'departments'" :class="fundsTab === 'departments' ? 'bg-white shadow-sm text-primary-700 font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'" class="px-4 py-1.5 text-xs rounded-md transition-all uppercase tracking-wider">Departments</button>
                                    <button @click="fundsTab = 'classes'" :class="fundsTab === 'classes' ? 'bg-white shadow-sm text-amber-700 font-bold' : 'text-gray-500 hover:text-gray-700 font-medium'" class="px-4 py-1.5 text-xs rounded-md transition-all uppercase tracking-wider">Classes</button>
                                </div>
                            </div>

                            <!-- Department Funds -->
                            <div x-show="fundsTab === 'departments'">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50/30">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Department</th>
                                                <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50 bg-white">
                                            @forelse($departmentFunds as $df)
                                                <tr class="hover:bg-primary-50/20 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">{{ $df->date_received->format('M d, Y') }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-900 font-bold">{{ $df->department->name ?? 'Unknown' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                                        <span class="text-sm font-black text-primary-700">GHS {{ number_format($df->amount, 2) }}</span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-[10px] font-mono text-gray-400 mb-0.5">#{{ $df->receipt_number }}</div>
                                                        <div class="text-xs text-gray-500">{{ $df->recordedBy->first_name ?? '' }} {{ $df->recordedBy->last_name ?? '' }}</div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No department funds recorded.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Class Funds -->
                            <div x-show="fundsTab === 'classes'" x-cloak>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50/30">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Class Name</th>
                                                <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Receipt #</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50 bg-white">
                                            @forelse($classFunds as $cf)
                                                <tr class="hover:bg-amber-50/30 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">{{ $cf->date_received->format('M d, Y') }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-900 font-bold">{{ $cf->class_name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                                        <span class="text-sm font-black text-amber-600">GHS {{ number_format($cf->amount, 2) }}</span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-[10px] font-mono text-gray-400">#{{ $cf->receipt_number }}</td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No class funds recorded.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <x-modal name="confirm-delete" maxWidth="sm">
            <div class="p-8">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h2 class="text-xl font-black text-gray-900 text-center tracking-tight">Delete Record?</h2>
                <p class="mt-3 text-sm text-gray-500 text-center leading-relaxed">
                    You are about to permanently delete <strong class="text-gray-900" x-text="deleteTitle"></strong>. This action cannot be undone.
                </p>
                <div class="mt-8 flex gap-3">
                    <button type="button" @click="$dispatch('close-modal', 'confirm-delete')" class="flex-1 py-3 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm active:scale-95">
                        Cancel
                    </button>
                    <form :action="deleteUrl" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="w-full py-3 bg-red-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-red-700 transition-all shadow-sm shadow-red-500/30 active:scale-95">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>
</x-app-layout>