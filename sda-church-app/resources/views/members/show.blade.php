<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Member Profile') }}
            </h2>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('members.edit', $member->member_id) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-secondary-400 hover:bg-secondary-500 border border-secondary-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary-400 focus:ring-offset-2 transition duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('members.index') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-600 hover:bg-primary-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Directory
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-neutral-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ═══════════════════════════════════════════
                 PROFILE HERO BANNER
            ═══════════════════════════════════════════ --}}
            <div class="rounded-xl overflow-hidden shadow-lg">
                {{-- Green gradient banner --}}
                <div class="relative bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600 px-6 pt-10 pb-0">
                    {{-- Subtle geometric texture overlay --}}
                    <div class="absolute inset-0 opacity-5"
                        style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 16px 16px;"></div>

                    {{-- Gold accent line top --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary-400 via-secondary-300 to-secondary-400"></div>

                    <div class="relative flex flex-col items-center pb-6 text-center">
                        {{-- Profile photo --}}
                        <div class="w-28 h-36 sm:w-32 sm:h-40 rounded-xl overflow-hidden ring-4 ring-white shadow-xl mb-4 flex-shrink-0">
                            @if($member->profile_picture)
                                <img src="{{ asset('storage/' . $member->profile_picture) }}"
                                    alt="Profile photo of {{ $member->first_name }} {{ $member->last_name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-primary-500 flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold uppercase select-none">
                                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight leading-tight mb-1">
                            {{ $member->first_name }} {{ $member->last_name }}
                        </h1>

                        {{-- Member ID --}}
                        <p class="text-primary-200 text-xs font-medium tracking-wider uppercase mb-3">
                            Member #{{ $member->member_id }}
                        </p>

                        {{-- Status badge --}}
                        @if($member->status === 'Active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                Active Member
                            </span>
                        @elseif($member->status === 'Inactive')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 inline-block"></span>
                                Inactive
                            </span>
                        @elseif($member->status === 'Transferred')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                                Transferred Out
                            </span>
                        @elseif($member->status === 'Deceased')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                Deceased
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-800 border border-neutral-200">
                                {{ $member->status }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- ─── Stats Strip ─── --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 bg-white border-t-2 border-secondary-400 divide-x divide-neutral-100">
                    {{-- Member Since --}}
                    <div class="px-4 py-4 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Member Since</p>
                            <p class="text-sm font-bold text-gray-800 leading-tight truncate">{{ $member->created_at->format('M Y') }}</p>
                        </div>
                    </div>

                    {{-- Baptism Year --}}
                    <div class="px-4 py-4 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Baptism Year</p>
                            <p class="text-sm font-bold text-gray-800 leading-tight">
                                {{ $member->baptism_date ? \Carbon\Carbon::parse($member->baptism_date)->format('Y') : '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Ministries --}}
                    <div class="px-4 py-4 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Ministries</p>
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ $member->departments->count() }}</p>
                        </div>
                    </div>

                    {{-- Years of Service --}}
                    <div class="px-4 py-4 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-secondary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Years of Service</p>
                            <p class="text-sm font-bold text-gray-800 leading-tight">
                                {{ $member->created_at->diffInYears(now()) }}
                                <span class="text-xs font-normal text-neutral-500">yrs</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════
                 TWO-COLUMN MAIN LAYOUT
            ═══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- LEFT COLUMN: Personal & Contact Details --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden">
                        {{-- Section header with primary left-border accent --}}
                        <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
                            <div class="w-1 h-6 rounded-full bg-primary-600 flex-shrink-0"></div>
                            <h3 class="text-base font-bold text-gray-800">Personal Details</h3>
                        </div>

                        <div class="px-6 py-4 space-y-4">

                            {{-- Gender --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Gender</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $member->gender ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Marital Status --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Marital Status</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $member->marital_status ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Date of Birth --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V9a6 6 0 016-6h6a6 6 0 016 6v6.546z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Date of Birth</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        @if($member->date_of_birth)
                                            {{ \Carbon\Carbon::parse($member->date_of_birth)->format('M d, Y') }}
                                            <span class="text-xs font-normal text-neutral-500">({{ \Carbon\Carbon::parse($member->date_of_birth)->age }} yrs)</span>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Email</p>
                                    <p class="text-sm font-semibold text-gray-800 break-all">{{ $member->email ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Phone</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $member->contact_number ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-0.5">Address</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $member->address ?? 'N/A' }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- Card A: Church Information --}}
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
                            <div class="w-1 h-6 rounded-full bg-secondary-400 flex-shrink-0"></div>
                            <h3 class="text-base font-bold text-gray-800">Church Information</h3>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">

                            <div>
                                <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-1">Baptism Date</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $member->baptism_date ? \Carbon\Carbon::parse($member->baptism_date)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-1">Membership Status</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    @if($member->status === 'Active')
                                        <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>
                                        <span class="text-sm font-semibold text-green-700">Active</span>
                                    @elseif($member->status === 'Inactive')
                                        <span class="w-2 h-2 rounded-full bg-yellow-500 flex-shrink-0"></span>
                                        <span class="text-sm font-semibold text-yellow-700">Inactive</span>
                                    @elseif($member->status === 'Transferred')
                                        <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                                        <span class="text-sm font-semibold text-blue-700">Transferred</span>
                                    @elseif($member->status === 'Deceased')
                                        <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span>
                                        <span class="text-sm font-semibold text-red-700">Deceased</span>
                                    @else
                                        <span class="text-sm font-semibold text-gray-800">{{ $member->status }}</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-1">Member Since</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $member->created_at->format('M d, Y') }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider leading-none mb-1">Record Created</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $member->created_at->format('M d, Y') }}</p>
                            </div>

                        </div>
                    </div>

                    {{-- Card B: Departments & Ministries --}}
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 rounded-full bg-primary-600 flex-shrink-0"></div>
                                <h3 class="text-base font-bold text-gray-800">Departments & Ministries</h3>
                            </div>
                            @can('update', $member)
                                <a href="{{ route('members.edit', $member->member_id) }}"
                                    class="text-xs font-medium text-primary-600 hover:text-primary-800 border border-primary-200 hover:border-primary-400 rounded-md px-2.5 py-1 bg-primary-50 hover:bg-primary-100 transition duration-150 focus:outline-none focus:ring-2 focus:ring-primary-400">
                                    Manage
                                </a>
                            @endcan
                        </div>
                        <div class="px-6 py-4">
                            @if($member->departments->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($member->departments as $dept)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800 border border-primary-200">
                                            {{ $dept->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-6 text-center">
                                    <div class="w-12 h-12 rounded-full bg-neutral-100 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-neutral-500 font-medium">No ministries assigned</p>
                                    <p class="text-xs text-neutral-400 mt-0.5">This member hasn't been added to any departments yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card C: Giving Overview (Finance-gated) --}}
                    @can('manage-finance')
                        <div class="rounded-xl shadow-sm overflow-hidden border border-emerald-200">
                            {{-- Gradient header --}}
                            <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-base font-bold text-white">Giving Overview</h3>
                                </div>
                                <span class="text-xs text-emerald-200 font-medium">Finance Restricted</span>
                            </div>
                            {{-- Stats --}}
                            <div class="bg-white grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-neutral-100">
                                <div class="px-6 py-5">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                        <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider">Total Tithes</p>
                                    </div>
                                    <p class="text-2xl font-bold text-emerald-800">
                                        GHS {{ number_format($member->tithes->sum('amount'), 2) }}
                                    </p>
                                </div>
                                <div class="px-6 py-5">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">Total Donations</p>
                                    </div>
                                    <p class="text-2xl font-bold text-blue-800">
                                        GHS {{ number_format($member->donations->sum('amount'), 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endcan

                </div>
            </div>

            {{-- ═══════════════════════════════════════════
                 BAPTISM & TRANSFER HISTORY
                 (only rendered if records exist)
            ═══════════════════════════════════════════ --}}
            @if($member->baptisms->count() > 0 || $member->transfers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Baptism Records --}}
                    @if($member->baptisms->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
                                <div class="w-1 h-6 rounded-full bg-primary-600 flex-shrink-0"></div>
                                <h3 class="text-base font-bold text-gray-800">Baptism Records</h3>
                                <span class="ml-auto text-xs font-semibold bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full">
                                    {{ $member->baptisms->count() }}
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-neutral-50 border-b border-neutral-100">
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Date</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Type</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-50">
                                        @foreach($member->baptisms as $baptism)
                                            <tr class="hover:bg-neutral-50 transition-colors duration-100">
                                                <td class="px-6 py-3 font-medium text-gray-700">
                                                    {{ isset($baptism->baptism_date) ? \Carbon\Carbon::parse($baptism->baptism_date)->format('M d, Y') : '—' }}
                                                </td>
                                                <td class="px-6 py-3 text-gray-600">
                                                    {{ $baptism->type ?? '—' }}
                                                </td>
                                                <td class="px-6 py-3 text-gray-500 text-xs">
                                                    {{ $baptism->notes ?? '—' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Transfer Records --}}
                    @if($member->transfers->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
                                <div class="w-1 h-6 rounded-full bg-blue-500 flex-shrink-0"></div>
                                <h3 class="text-base font-bold text-gray-800">Transfer History</h3>
                                <span class="ml-auto text-xs font-semibold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
                                    {{ $member->transfers->count() }}
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-neutral-50 border-b border-neutral-100">
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Date</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">From / To</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-50">
                                        @foreach($member->transfers as $transfer)
                                            <tr class="hover:bg-neutral-50 transition-colors duration-100">
                                                <td class="px-6 py-3 font-medium text-gray-700">
                                                    {{ isset($transfer->transfer_date) ? \Carbon\Carbon::parse($transfer->transfer_date)->format('M d, Y') : '—' }}
                                                </td>
                                                <td class="px-6 py-3 text-gray-600 text-xs">
                                                    @if(isset($transfer->from_church) || isset($transfer->to_church))
                                                        {{ $transfer->from_church ?? '—' }} &rarr; {{ $transfer->to_church ?? '—' }}
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                        {{ $transfer->status ?? 'Transferred' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

        </div>
    </div>
</x-app-layout>
