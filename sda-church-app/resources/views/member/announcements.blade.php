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
                @php
                    $isRead = in_array($announcement->announcement_id, $readAnnouncementIds);
                @endphp
                <article 
                    x-data="{ read: {{ $isRead ? 'true' : 'false' }} }"
                    @click="
                        $dispatch('open-modal', 'announcement-modal-{{ $announcement->announcement_id }}');
                        if (!read) {
                            fetch('{{ route('member.announcements.read', $announcement->announcement_id) }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            }).then(response => {
                                if(response.ok) {
                                    read = true;
                                    let desktopBadge = document.getElementById('announcement-badge-desktop');
                                    let mobileBadge = document.getElementById('announcement-badge-mobile');
                                    if(desktopBadge) {
                                        let count = parseInt(desktopBadge.innerText) - 1;
                                        if(count > 0) desktopBadge.innerText = count;
                                        else desktopBadge.style.display = 'none';
                                    }
                                    if(mobileBadge) {
                                        let count = parseInt(mobileBadge.innerText) - 1;
                                        if(count > 0) mobileBadge.innerText = count;
                                        else mobileBadge.style.display = 'none';
                                    }
                                }
                            });
                        }
                    "
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-md transition duration-150 ease-in-out relative"
                    :class="read ? 'opacity-80' : ''"
                >
                    <div class="h-1 bg-gradient-to-r" :class="read ? 'from-gray-300 to-gray-200' : 'from-primary-500 to-primary-300'"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-gray-900 text-lg leading-snug">
                                    {{ $announcement->title }}
                                </h3>
                                <template x-if="!read">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        New
                                    </span>
                                </template>
                            </div>
                            <span class="shrink-0 text-xs text-gray-400 pt-1">
                                {{ \Carbon\Carbon::parse($announcement->publish_date)->format('M d, Y') }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line line-clamp-2">
                            {{ $announcement->content }}
                        </p>
                    </div>
                </article>

                <x-modal name="announcement-modal-{{ $announcement->announcement_id }}" maxWidth="lg">
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">
                            {{ $announcement->title }}
                        </h2>
                        <div class="text-xs text-gray-500 mb-4 border-b pb-2">
                            Posted on {{ \Carbon\Carbon::parse($announcement->publish_date)->format('F j, Y') }}
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line mb-4">
                            {{ $announcement->content }}
                        </p>
                        @if($announcement->expiry_date)
                            <p class="mt-4 text-xs text-amber-600 font-medium">
                                Expires {{ \Carbon\Carbon::parse($announcement->expiry_date)->format('F j, Y') }}
                            </p>
                        @endif
                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Close') }}
                            </x-secondary-button>
                        </div>
                    </div>
                </x-modal>
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
