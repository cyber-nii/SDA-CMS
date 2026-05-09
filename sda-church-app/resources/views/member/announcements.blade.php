<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('member.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                {{ __('Church Announcements') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse($announcements as $announcement)
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-1 bg-gradient-to-r from-primary-500 to-primary-300"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <h3 class="font-bold text-gray-900 text-lg leading-snug">
                                {{ $announcement->title }}
                            </h3>
                            <span class="shrink-0 text-xs text-gray-400 pt-1">
                                {{ \Carbon\Carbon::parse($announcement->publish_date)->format('M d, Y') }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $announcement->content }}
                        </p>
                        @if($announcement->expiry_date)
                            <p class="mt-4 text-xs text-amber-600 font-medium">
                                Expires {{ \Carbon\Carbon::parse($announcement->expiry_date)->format('F j, Y') }}
                            </p>
                        @endif
                    </div>
                </article>
            @empty
                <div class="text-center py-20">
                    <svg class="mx-auto w-14 h-14 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <p class="text-gray-400 text-sm italic">No announcements at this time. Check back later.</p>
                </div>
            @endforelse

            @if($announcements->hasPages())
                <div class="pt-2">
                    {{ $announcements->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
