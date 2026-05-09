<x-guest-layout>

    <div class="mb-8">
        <div class="w-12 h-12 bg-primary-50 rounded-full flex items-center justify-center mb-4">
            <svg aria-hidden="true" class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-neutral-900">Verify your email</h2>
        <p class="mt-1 text-sm text-neutral-500">
            We sent a verification link to your email address. Click it to activate your account.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <x-primary-button class="w-full justify-center py-2.5" x-bind:disabled="loading">
                <span x-show="!loading">Resend Verification Email</span>
                <span x-show="loading" x-cloak class="inline-flex items-center gap-2">
                    <svg aria-hidden="true" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    Sending…
                </span>
            </x-primary-button>
        </form>

        <div class="relative">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-neutral-200"></div></div>
            <div class="relative flex justify-center text-xs text-neutral-400"><span class="bg-white px-2">or</span></div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full text-sm text-center text-neutral-500 hover:text-neutral-800 transition-colors py-2">
                Sign out of this account
            </button>
        </form>
    </div>

</x-guest-layout>
