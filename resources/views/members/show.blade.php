<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Member Profile') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('members.edit', $member->member_id) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit Profile
                </a>
                <a href="{{ route('members.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    &larr; Back to Directory
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Sidebar -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6 flex flex-col items-center">
                    <div class="w-48 aspect-[3/4] rounded-lg overflow-hidden border-2 border-gray-100 shadow-lg mb-4">
                        @if($member->profile_picture)
                            <img src="{{ asset('storage/' . $member->profile_picture) }}" alt="Profile"
                                class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-primary-100 flex items-center justify-center text-primary-700 text-4xl font-bold uppercase shadow-inner">
                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $member->first_name }} {{ $member->last_name }}
                    </h3>
                    <p class="text-gray-500 mb-4">{{ $member->status }} Member</p>

                    @if($member->status === 'Active')
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 mb-6 w-full justify-center">Active
                            Member</span>
                    @elseif($member->status === 'Inactive')
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mb-6 w-full justify-center">Inactive
                            Member</span>
                    @elseif($member->status === 'Transferred')
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mb-6 w-full justify-center">Transferred
                            Out</span>
                    @else
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 mb-6 w-full justify-center">{{ $member->status }}</span>
                    @endif

                    <div class="w-full border-t border-gray-200 pt-4 mt-2 space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm text-gray-600 break-all">{{ $member->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $member->contact_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $member->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Main Details -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Personal Info Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Personal Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Gender</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">{{ $member->gender }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Date of Birth</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    {{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('M d, Y') . ' (' . \Carbon\Carbon::parse($member->date_of_birth)->age . ' yrs)' : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Baptism Date</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    {{ $member->baptism_date ? \Carbon\Carbon::parse($member->baptism_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Member Since</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    {{ $member->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Department Memberships Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h4 class="text-lg font-bold text-gray-900">Departments & Ministries</h4>
                            <button
                                class="text-primary-600 hover:text-primary-800 text-sm font-medium text-xs border border-primary-200 rounded px-2 py-1 bg-primary-50">Manage</button>
                        </div>

                        @if($member->departments->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($member->departments as $dept)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                        {{ $dept->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">This member is not assigned to any departments
                                currently.</p>
                        @endif
                    </div>

                    @can('manage-finance')
                        <!-- Financial Summary Card (Only visible to authorized roles) -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Giving Overview
                                </h4>
                                <a href="#" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium text-xs">View
                                    History &rarr;</a>
                            </div>

                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div class="bg-emerald-50 rounded-lg p-3 border border-emerald-100">
                                    <p class="text-xs text-emerald-600 font-bold uppercase">Total Tithes</p>
                                    <p class="text-xl font-bold text-emerald-800">GHS
                                        {{ number_format($member->tithes->sum('amount'), 2) }}</p>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-3 border border-blue-100 col-span-2">
                                    <p class="text-xs text-blue-600 font-bold uppercase">Total Donations</p>
                                    <p class="text-xl font-bold text-blue-800">GHS
                                        {{ number_format($member->donations->sum('amount'), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endcan

                </div>
            </div>

        </div>
    </div>
</x-app-layout>