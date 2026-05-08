<x-app-layout>
    @push('styles')
    <style>
        @media print {
            @page { size: A4; margin: 20mm; }
            body { background: white !important; color: black !important; }
            nav, header, footer, .no-print { display: none !important; }
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Department Funds') }}
            </h2>
            <div class="flex items-center gap-3 no-print">
                <x-export-dropdown :routes="[
                    'csv' => route('funds-controller.departments.export', array_merge(request()->query(), ['format' => 'csv'])),
                    'pdf' => route('funds-controller.departments.export', array_merge(request()->query(), ['format' => 'pdf']))
                ]" />
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-800 transition-all duration-300 shadow-sm hover:shadow-lg active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfd] min-h-screen print:min-h-0 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-primary-50/40 to-transparent pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            <!-- Print Header -->
            <div class="hidden print:block text-center border-b-2 border-gray-800 pb-6 mb-8 mt-4">
                <h1 class="text-3xl font-black uppercase tracking-wider text-gray-900">SDA Church</h1>
                <h2 class="text-xl font-semibold text-gray-600 mt-1">Department Funds Report</h2>
                <p class="text-sm text-gray-500 mt-2">Generated on: {{ now()->format('F j, Y - h:i A') }}</p>
                <p class="text-sm text-gray-500">Prepared by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
            </div>

            <!-- Alert -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="bg-primary-50 border-l-4 border-primary-600 text-primary-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between no-print" role="alert">
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

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm no-print" role="alert">
                    <strong class="font-bold">Please check your inputs:</strong>
                    <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 no-print">
                <!-- Total Collected — SDA Green -->
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-primary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-primary-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-primary-500 mr-2 animate-pulse"></span>
                            Total Collected
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">GHS {{ number_format($departmentFunds->sum('amount'), 2) }}</p>
                    </div>
                </div>

                <!-- Total Records — SDA Gold -->
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-secondary-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-secondary-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-secondary-600 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-secondary-400 mr-2"></span>
                            Total Records
                        </h2>
                        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $departmentFunds->count() }}</p>
                    </div>
                </div>

                <!-- Latest Entry — Neutral -->
                <div class="group relative bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-gray-900/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-neutral-50 rounded-full opacity-60 group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    <div class="relative z-10">
                        <h2 class="font-black text-neutral-500 text-xs uppercase tracking-widest mb-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-neutral-400 mr-2"></span>
                            Latest Entry
                        </h2>
                        <p class="text-2xl font-black text-gray-900 tracking-tight">
                            {{ $departmentFunds->first() ? $departmentFunds->first()->date_received->format('M d, Y') : '—' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <!-- Record Form -->
                <div class="xl:col-span-1 no-print">
                    <div class="bg-white rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-600 via-primary-400 to-secondary-400"></div>
                        <h3 class="font-black text-xl text-gray-900 mb-6 tracking-tight flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Record Department Fund
                        </h3>
                        <form action="{{ route('funds-controller.departments.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Select Department</label>
                                <select name="department_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors text-sm py-3" required>
                                    <option value="">— Choose Department —</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->department_id }}" {{ old('department_id') == $department->department_id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Amount (GHS)</label>
                                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" placeholder="0.00" required>
                                    @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date</label>
                                    <input type="date" name="date_received" value="{{ old('date_received', date('Y-m-d')) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 transition-colors sm:text-sm py-3" required>
                                    @error('date_received') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all hover:shadow-lg active:scale-95 mt-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Save & Generate Receipt
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Records Table -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:border-none print:shadow-none">

                        <!-- Print-only title -->
                        <div class="hidden print:block text-center font-bold text-xl py-4 border-b border-gray-200">
                            SDA Church — Department Funds Report
                        </div>

                        <!-- Table Header + Filters -->
                        <div class="p-6 border-b border-gray-50 bg-gray-50/30 no-print">
                            <div class="flex flex-wrap gap-3 items-center justify-between">
                                <h3 class="font-black text-xl text-gray-900 tracking-tight flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full bg-primary-600 mr-2.5"></span>
                                    Department Fund Records
                                </h3>
                                <form method="GET" action="{{ route('funds-controller.departments') }}" class="flex flex-wrap gap-2 items-center">
                                    <input type="text" name="search" placeholder="Search receipt or dept…"
                                           value="{{ request('search') }}"
                                           class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-3 w-48">
                                    <input type="date" name="start_date" value="{{ request('start_date') }}" title="Start Date"
                                           class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-3 w-36">
                                    <input type="date" name="end_date" value="{{ request('end_date') }}" title="End Date"
                                           class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-3 w-36">
                                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-primary-700 transition-all active:scale-95 shadow-sm">
                                        Filter
                                    </button>
                                    @if(request('search') || request('start_date') || request('end_date'))
                                        <a href="{{ route('funds-controller.departments') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-200 transition-all">
                                            Clear
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Department</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Receipt No.</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest no-print">Recorded By</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    @forelse($departmentFunds as $fund)
                                        <tr class="hover:bg-primary-50/40 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                                {{ $fund->date_received->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                {{ $fund->department->name ?? 'Unknown' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-black text-primary-700 bg-primary-50 px-2.5 py-1 rounded-md">GHS {{ number_format($fund->amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-[11px] font-mono font-bold bg-secondary-50 text-secondary-700 border border-secondary-100 px-2.5 py-1 rounded-md tracking-wide">{{ $fund->receipt_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 no-print">
                                                {{ $fund->recordedBy->first_name ?? '' }} {{ $fund->recordedBy->last_name ?? '' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center">
                                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-sm text-gray-400 font-medium">No department funds recorded yet.</p>
                                                <p class="text-xs text-gray-300 mt-1">Use the form to record the first entry.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($departmentFunds->count() > 0)
                                <tfoot class="bg-gray-50/80 border-t-2 border-gray-100">
                                    <tr>
                                        <td colspan="2" class="px-6 py-3 text-xs font-black text-gray-500 uppercase tracking-widest">
                                            {{ $departmentFunds->count() }} {{ Str::plural('record', $departmentFunds->count()) }}
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <span class="text-sm font-black text-gray-900">GHS {{ number_format($departmentFunds->sum('amount'), 2) }}</span>
                                        </td>
                                        <td colspan="2" class="px-6 py-3 text-xs text-gray-400 no-print">Total</td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
