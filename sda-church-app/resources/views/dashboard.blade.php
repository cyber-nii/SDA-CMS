<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-neutral-900 tracking-tight leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="text-sm font-medium text-neutral-500 bg-white px-4 py-1.5 rounded-full shadow-sm border border-neutral-200">
                Welcome, <span class="text-primary-700">{{ auth()->user()?->first_name ?? 'Admin' }}</span> <span class="text-neutral-400">({{ auth()->user()?->role ?? 'Guest' }})</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-neutral-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Members Card -->
                <a href="{{ route('members.index') }}" class="bg-white rounded-2xl shadow-sm border border-neutral-200 p-6 flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-primary-600/5 hover:border-primary-200 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-2xl"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="p-3.5 rounded-xl bg-primary-600 text-white shadow-md shadow-primary-600/20 shrink-0 transition-transform duration-300 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-500 text-sm">Total Members</p>
                            <p class="text-3xl font-bold text-neutral-900 tracking-tight">{{ number_format($membersCount) }}</p>
                        </div>
                    </div>
                </a>

                <!-- Departments Card -->
                <a href="{{ route('departments.index') }}" class="bg-white rounded-2xl shadow-sm border border-neutral-200 p-6 flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-secondary-500/5 hover:border-secondary-200 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-secondary-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-2xl"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="p-3.5 rounded-xl bg-secondary-500 text-white shadow-md shadow-secondary-500/20 shrink-0 transition-transform duration-300 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-500 text-sm">Departments</p>
                            <p class="text-3xl font-bold text-neutral-900 tracking-tight">{{ number_format($departmentsCount) }}</p>
                        </div>
                    </div>
                </a>

                <!-- Baptisms Card -->
                <a href="{{ route('baptisms.index') }}" class="bg-white rounded-2xl shadow-sm border border-neutral-200 p-6 flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-teal-600/5 hover:border-teal-200 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-teal-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-2xl"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="p-3.5 rounded-xl bg-teal-600 text-white shadow-md shadow-teal-600/20 shrink-0 transition-transform duration-300 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-500 text-sm">Baptisms Record</p>
                            <p class="text-3xl font-bold text-neutral-900 tracking-tight">{{ number_format($baptismsCount) }}</p>
                        </div>
                    </div>
                </a>

                <!-- Finance Card -->
                <a href="{{ route('finance.index') }}" class="bg-white rounded-2xl shadow-sm border border-neutral-200 p-6 flex flex-col justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-600/5 hover:border-emerald-200 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-2xl"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="p-3.5 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/20 shrink-0 transition-transform duration-300 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-medium text-neutral-500 text-sm">Financial Recs.</p>
                            <p class="text-3xl font-bold text-neutral-900 tracking-tight">GHS {{ number_format($totalFinances, 2) }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                <!-- Activity Log -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-neutral-200 p-8">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-lg font-bold text-neutral-900">Recent Activities</h3>
                            <p class="text-sm text-neutral-500 mt-1">Latest actions recorded in the system.</p>
                        </div>
                        <a href="{{ route('activity-log.index') }}" class="text-primary-600 hover:text-primary-800 text-sm font-semibold transition-colors flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    
                    <div class="relative pl-4 sm:pl-6 border-l-2 border-neutral-100 space-y-8">
                        @forelse($activities as $activity)
                            <div class="relative group">
                                <div class="absolute -left-[21px] sm:-left-[29px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-primary-500 group-hover:bg-primary-500 group-hover:shadow-[0_0_0_4px_rgba(46,95,59,0.1)] transition-all duration-300"></div>
                                <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-2 sm:gap-4 pl-2">
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-900 group-hover:text-primary-700 transition-colors">{{ $activity->action }}</p>
                                        <p class="text-sm text-neutral-500 mt-1 leading-relaxed">{{ $activity->description }}</p>
                                        <p class="text-xs text-neutral-400 mt-1 font-medium">By {{ optional($activity->user)->first_name ?? 'System' }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-50 text-neutral-500 border border-neutral-200 whitespace-nowrap self-start">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-neutral-400">
                                <div class="w-16 h-16 mx-auto mb-4 bg-neutral-50 rounded-full flex items-center justify-center border border-neutral-100">
                                    <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h4 class="text-neutral-900 font-medium mb-1">No activities found</h4>
                                <p class="text-sm mb-4">There are no recent activities recorded yet.</p>
                                <a href="{{ route('members.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                                    Register your first member
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Sidebar: Quick Actions & Charts -->
                <div class="space-y-8">
                    <!-- Gender Distribution Bar -->
                    <div class="bg-white rounded-3xl shadow-sm border border-neutral-200 p-6">
                        <h3 class="text-base font-bold text-neutral-900 mb-5 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Gender Distribution
                        </h3>

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 bg-neutral-50 px-3 py-1.5 rounded-lg border border-neutral-100">
                                <span class="w-2.5 h-2.5 rounded-sm bg-primary-600 shadow-sm"></span>
                                <span class="text-xs font-medium text-neutral-600">Men</span>
                                <span class="text-xs font-bold text-neutral-900 ml-1">{{ $maleCount }}</span>
                            </div>
                            <div class="flex items-center gap-2 bg-neutral-50 px-3 py-1.5 rounded-lg border border-neutral-100">
                                <span class="w-2.5 h-2.5 rounded-sm bg-secondary-500 shadow-sm"></span>
                                <span class="text-xs font-medium text-neutral-600">Women</span>
                                <span class="text-xs font-bold text-neutral-900 ml-1">{{ $femaleCount }}</span>
                            </div>
                        </div>

                        @php
                            $malePercent = $membersCount > 0 ? round(($maleCount / $membersCount) * 100, 1) : 0;
                            $femalePercent = $membersCount > 0 ? round(($femaleCount / $membersCount) * 100, 1) : 0;
                        @endphp
                        <div class="w-full h-4 rounded-full overflow-hidden flex bg-neutral-100 mb-2">
                            @if($maleCount > 0)
                                <div class="h-full bg-primary-600 transition-all duration-1000 ease-out"
                                    style="width: {{ $malePercent }}%;">
                                </div>
                            @endif
                            @if($femaleCount > 0)
                                <div class="h-full bg-secondary-500 transition-all duration-1000 ease-out"
                                    style="width: {{ $femalePercent }}%;">
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-between text-[10px] font-semibold text-neutral-400">
                            @if($maleCount > 0)<span>{{ $malePercent }}%</span>@else<span></span>@endif
                            @if($femaleCount > 0)<span>{{ $femalePercent }}%</span>@else<span></span>@endif
                        </div>
                        
                        @if($membersCount === 0)
                            <div class="w-full h-4 rounded-full bg-neutral-100 flex items-center justify-center mt-[-1.5rem]">
                                <span class="text-[10px] font-medium text-neutral-400 italic">No members yet</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-3xl shadow-sm border border-neutral-200 p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 rounded-lg bg-secondary-50 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h3 class="text-base font-bold text-neutral-900">Quick Actions</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <a href="{{ route('members.create') }}" class="group flex items-center p-3 text-sm font-medium text-neutral-700 bg-neutral-50 rounded-xl border border-neutral-100 hover:border-primary-200 hover:bg-primary-50 hover:text-primary-800 transition-all duration-200 hover:shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3 text-neutral-400 group-hover:text-primary-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                </div>
                                Register New Member
                                <svg class="w-4 h-4 ml-auto text-neutral-300 group-hover:text-primary-500 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            
                            @can('manage-finance')
                            <a href="{{ route('finance.index') }}" class="group flex items-center p-3 text-sm font-medium text-neutral-700 bg-neutral-50 rounded-xl border border-neutral-100 hover:border-primary-200 hover:bg-primary-50 hover:text-primary-800 transition-all duration-200 hover:shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3 text-neutral-400 group-hover:text-primary-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                Log Tithes &amp; Offerings
                                <svg class="w-4 h-4 ml-auto text-neutral-300 group-hover:text-primary-500 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            @endcan
                            
                            <a href="{{ route('documents.create') }}" class="group flex items-center p-3 text-sm font-medium text-neutral-700 bg-neutral-50 rounded-xl border border-neutral-100 hover:border-primary-200 hover:bg-primary-50 hover:text-primary-800 transition-all duration-200 hover:shadow-sm">
                                <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3 text-neutral-400 group-hover:text-primary-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                Upload Document
                                <svg class="w-4 h-4 ml-auto text-neutral-300 group-hover:text-primary-500 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
