<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-neutral-900 leading-tight">Recent Activities</h2>
                <p class="text-sm text-neutral-500 mt-0.5">Full system activity log</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-neutral-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search -->
            <form method="GET" action="{{ route('activity-log.index') }}" class="flex gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Search by action or description…"
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-neutral-200 bg-white text-sm text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent shadow-sm">
                </div>
                <button type="submit"
                        class="px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition shadow-sm">
                    Search
                </button>
                @if($search)
                    <a href="{{ route('activity-log.index') }}"
                       class="px-4 py-2.5 bg-white border border-neutral-200 text-neutral-600 text-sm font-medium rounded-xl hover:bg-neutral-50 transition shadow-sm">
                        Clear
                    </a>
                @endif
            </form>

            <!-- Activity List -->
            <div class="bg-white rounded-3xl shadow-sm border border-neutral-200 p-8">

                @if($search)
                    <p class="text-sm text-neutral-500 mb-6">
                        Showing results for <span class="font-semibold text-neutral-800">"{{ $search }}"</span>
                        — {{ $activities->total() }} {{ Str::plural('entry', $activities->total()) }} found
                    </p>
                @endif

                <div class="relative pl-4 sm:pl-6 border-l-2 border-neutral-100 space-y-8">
                    @forelse($activities as $activity)
                        <div class="relative group">
                            <div class="absolute -left-[21px] sm:-left-[29px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-primary-500 group-hover:bg-primary-500 group-hover:shadow-[0_0_0_4px_rgba(46,95,59,0.1)] transition-all duration-300"></div>
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-2 sm:gap-4 pl-2">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-neutral-900 group-hover:text-primary-700 transition-colors">
                                        {{ $activity->action }}
                                    </p>
                                    <p class="text-sm text-neutral-500 mt-1 leading-relaxed">{{ $activity->description }}</p>
                                    <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                        <p class="text-xs text-neutral-400 font-medium">
                                            By {{ optional($activity->user)->first_name ?? 'System' }}
                                            {{ optional($activity->user)->last_name ?? '' }}
                                        </p>
                                        @if($activity->ip_address)
                                            <span class="text-xs text-neutral-300">·</span>
                                            <p class="text-xs text-neutral-400 font-mono">{{ $activity->ip_address }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="shrink-0 flex flex-col items-end gap-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-50 text-neutral-500 border border-neutral-200 whitespace-nowrap">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                    <span class="text-[10px] text-neutral-400">
                                        {{ $activity->created_at->format('M d, Y · g:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 mx-auto mb-4 bg-neutral-50 rounded-full flex items-center justify-center border border-neutral-100">
                                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h4 class="text-neutral-900 font-medium mb-1">No activities found</h4>
                            <p class="text-sm text-neutral-400">
                                {{ $search ? 'Try a different search term.' : 'There are no recorded activities yet.' }}
                            </p>
                        </div>
                    @endforelse
                </div>

                @if($activities->hasPages())
                    <div class="mt-8 pt-6 border-t border-neutral-100">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
