<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SDA CMS') }}</title>

    <link rel="icon" href="/images/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ── Mobile header (hidden on desktop) ──────────────────────── --}}
    <div class="lg:hidden bg-primary-700 px-6 pt-10 pb-8 flex flex-col items-center text-white">
        <img src="/images/logo.png" class="w-14 h-auto mb-3 drop-shadow-lg" alt="{{ config('app.name') }} logo">
        <p class="text-base font-bold tracking-tight">SDA Church Management</p>
        <p class="text-primary-300 text-xs mt-1">Serving with faithfulness &amp; integrity</p>
    </div>

    {{-- ── Left panel: branding (desktop only) ────────────────────── --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 relative overflow-hidden flex-col">

        {{-- Background image --}}
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('/images/login-bg.png');"></div>

        {{-- Gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-950/92 via-primary-900/82 to-primary-800/75"></div>

        {{-- Decorative blobs --}}
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-secondary-400/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-primary-950/40 blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 right-0 w-40 h-40 rounded-full bg-secondary-500/8 blur-xl pointer-events-none"></div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col h-full px-12 xl:px-16 py-12">

            {{-- Top: logo + app name --}}
            <div class="flex items-center gap-3">
                <img src="/images/logo.png" class="w-9 h-auto drop-shadow-lg" alt="{{ config('app.name') }} logo">
                <span class="text-white/90 font-semibold text-sm tracking-wide">SDA Church CMS</span>
            </div>

            {{-- Middle: headline + features --}}
            <div class="my-auto py-16">
                <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-5">
                    Serving your<br>congregation<br>
                    <span class="text-secondary-400">with care.</span>
                </h1>
                <p class="text-primary-200 text-sm leading-relaxed max-w-xs mb-10">
                    A complete management system built for SDA churches —
                    from members to finance to ministry records.
                </p>

                <div class="space-y-3.5">
                    @foreach([
                        'Member &amp; department management',
                        'Tithes, offerings &amp; financial reports',
                        'Baptism &amp; transfer records',
                        'Document library &amp; announcements',
                    ] as $feature)
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-secondary-400/20 border border-secondary-400/30 flex items-center justify-center flex-shrink-0">
                            <svg aria-hidden="true" class="w-3 h-3 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-primary-100 text-sm">{!! $feature !!}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Bottom: copyright --}}
            <div class="border-t border-primary-700/50 pt-6">
                <p class="text-primary-400/80 text-xs">&copy; {{ date('Y') }} SDA Church Management System. All rights reserved.</p>
            </div>

        </div>
    </div>

    {{-- ── Right panel: form ───────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col items-center justify-center bg-neutral-50 px-6 py-12 sm:px-10 lg:py-16">
        <div class="w-full max-w-md">

            {{-- Form card --}}
            <div class="bg-white rounded-2xl shadow-md border border-neutral-200/80 px-8 py-10 sm:px-10">
                {{ $slot }}
            </div>

            {{-- Footer note --}}
            <p class="mt-6 text-center text-xs text-neutral-400">
                Need help? Contact your church administrator.
            </p>

        </div>
    </div>

</div>
</body>

</html>
