<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('My Member Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Premium Profile Overview Section -->
            <div class="relative bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow duration-300">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-gradient-to-br from-primary-50 to-purple-50 blur-3xl opacity-60"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-gradient-to-tr from-blue-50 to-primary-50 blur-3xl opacity-60"></div>
                
                <div class="p-8 sm:p-10 relative z-10 flex flex-col sm:flex-row gap-8 items-center sm:items-stretch">
                    <!-- Avatar Frame -->
                    <div class="shrink-0 flex justify-center sm:justify-start">
                        <div class="w-32 sm:w-40 aspect-[3/4] rounded-2xl overflow-hidden shadow-md border border-gray-100/50 bg-gradient-to-b from-gray-50 to-gray-100 flex items-center justify-center transform group-hover:scale-[1.02] transition-transform duration-500">
                            @if($member->profile_picture)
                                <img src="{{ asset('storage/' . $member->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl sm:text-5xl font-black text-primary-200/80 uppercase tracking-tighter">
                                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Member Details -->
                    <div class="flex-1 flex flex-col justify-center text-center sm:text-left">
                        
                        <!-- Status Badge -->
                        <div class="mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest shadow-sm border {{ $member->status == 'Active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $member->status == 'Active' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $member->status }} MEMBER
                            </span>
                        </div>

                        <!-- Name -->
                        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-2">
                            {{ $member->first_name }} <span class="text-primary-600">{{ $member->last_name }}</span>
                        </h1>
                        
                        <!-- Email -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-gray-500 mt-2">
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="font-medium">{{ $member->email ?? 'No email provided' }}</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Left Column (Personal Info) -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Personal Information</h3>
                        <ul class="space-y-4">
                            <li>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Phone Number</span>
                                <span class="text-gray-800 font-medium">{{ $member->contact_number ?? 'N/A' }}</span>
                            </li>
                            <li>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Address</span>
                                <span class="text-gray-800 font-medium">{{ $member->address ?? 'N/A' }}</span>
                            </li>
                            <li>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Gender</span>
                                <span class="text-gray-800 font-medium">{{ $member->gender }}</span>
                            </li>
                            <li>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date of Birth</span>
                                <span class="text-gray-800 font-medium">{{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('F j, Y') : 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Church Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Church Information</h3>
                        <ul class="space-y-4">
                            <li>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Baptism Date</span>
                                <span class="text-gray-800 font-medium">{{ $member->baptism_date ? \Carbon\Carbon::parse($member->baptism_date)->format('F j, Y') : 'Not Baptized' }}</span>
                            </li>
                            <li>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">System Role</span>
                                <span class="text-gray-800 font-medium">{{ $user->role }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column (Departments & Finances) -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Departments -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            My Departments / Ministries
                        </h3>
                        @if($member->departments->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($member->departments as $dept)
                                    <span class="px-3 py-1.5 bg-primary-50 text-primary-700 rounded-lg text-sm font-medium border border-primary-100 shadow-sm">{{ $dept->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic">You are not currently assigned to any departments.</p>
                        @endif
                    </div>

                    <!-- Finances Summary -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-4">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Financial Contributions Overview
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <h4 class="text-sm font-semibold text-gray-500 mb-1">Total Tithes Paid</h4>
                                <p class="text-2xl font-bold text-gray-800">GHS {{ number_format($member->tithes()->sum('amount'), 2) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <h4 class="text-sm font-semibold text-gray-500 mb-1">Total Special Donations</h4>
                                <p class="text-2xl font-bold text-gray-800">GHS {{ number_format($member->donations()->sum('amount'), 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t text-sm text-gray-500 text-center italic">
                            Regular offerings are collected anonymously and not tied to individual profiles.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
