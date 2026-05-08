<x-guest-layout>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-neutral-900">Forgot password?</h2>
        <p class="mt-1 text-sm text-neutral-500">
            Enter your email and we'll send a reset link.
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5"
          x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email"
                          :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <x-primary-button class="w-full justify-center py-2.5" x-bind:disabled="loading">
            <span x-show="!loading">Send Reset Link</span>
            <span x-show="loading" x-cloak class="inline-flex items-center gap-2">
                <svg aria-hidden="true" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Sending…
            </span>
        </x-primary-button>

        <p class="text-center text-sm text-neutral-500">
            Remembered it?
            <a href="{{ route('login') }}"
               class="font-medium text-primary-600 hover:text-primary-800 transition-colors">
                Back to sign in
            </a>
        </p>

    </form>

</x-guest-layout>
