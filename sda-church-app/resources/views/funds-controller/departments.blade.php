<x-app-layout>
    @push('styles')
        <style>
            @media print {

                nav,
                form,
                .no-print {
                    display: none !important;
                }

                body {
                    font-family: Helvetica, Arial, sans-serif;
                }

                .print-title {
                    display: block !important;
                    text-align: center;
                    font-size: 22px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: left;
                }
            }

            .print-title {
                display: none;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments Funds') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 border-b border-gray-200">
                <h3 class="text-lg font-bold mb-4">Record New Department Fund</h3>
                <form action="{{ route('funds-controller.departments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="department_id" :value="__('Select Department')" />
                            <select id="department_id" name="department_id"
                                class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                required>
                                <option value="">-- Choose Department --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->department_id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Amount (GHS)')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount"
                                required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="date_received" :value="__('Date')" />
                            <x-text-input id="date_received" class="block mt-1 w-full" type="date" name="date_received"
                                value="{{ date('Y-m-d') }}" required />
                            <x-input-error :messages="$errors->get('date_received')" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-primary-button>
                            {{ __('Save Department Fund & Generate Receipt') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 border-b border-gray-200 mb-4">
                <div class="print-title">SDA Church — Department Funds Report</div>
                <form method="GET" action="{{ route('funds-controller.departments') }}" class="w-full no-print">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <!-- Title -->
                        <div class="md:col-span-3">
                            <h3 class="text-lg font-bold">Recent Dept. Funds</h3>
                        </div>

                        <!-- Search Bar -->
                        <div class="md:col-span-4 lg:col-span-4">
                            <x-text-input name="search" type="text" class="block w-full text-sm"
                                placeholder="Search receipt or department..." value="{{ request('search') }}" />
                        </div>

                        <!-- Date Filter + Actions (Extreme Right) -->
                        <div class="md:col-span-5 lg:col-span-5 flex justify-end items-center gap-2 flex-wrap">
                            <x-text-input name="start_date" type="date" class="block w-full md:w-32 text-sm"
                                value="{{ request('start_date') }}" title="Start Date" />
                            <span class="text-gray-500 font-medium">to</span>
                            <x-text-input name="end_date" type="date" class="block w-full md:w-32 text-sm"
                                value="{{ request('end_date') }}" title="End Date" />
                            <x-primary-button class="py-1.5 px-3">Filter</x-primary-button>
                            @if(request('search') || request('start_date') || request('end_date'))
                                <a href="{{ route('funds-controller.departments') }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 transition duration-150 ease-in-out">Clear</a>
                            @endif
                            <x-export-dropdown :routes="[
        'csv' => route('funds-controller.departments.export', array_merge(request()->query(), ['format' => 'csv'])),
        'pdf' => route('funds-controller.departments.export', array_merge(request()->query(), ['format' => 'pdf']))
    ]" />
                            <button type="button" onclick="window.print()"
                                class="inline-flex items-center px-3 py-1.5 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition duration-150">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                    </path>
                                </svg>
                                Print
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-6 text-gray-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Department</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Receipt No.</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($departmentFunds as $fund)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fund->date_received->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fund->department->name ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">GHS
                                        {{ number_format($fund->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $fund->receipt_number }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No
                                        department funds recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>