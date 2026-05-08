<x-guest-layout>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-neutral-900">Welcome back</h2>
        <p class="mt-1 text-sm text-neutral-500">Sign in to your church account</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5"
          x-data="{ loading: false }" @submit="loading = true">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Password with show/hide toggle --}}
        <div x-data="{ show: false }">
            <div class="flex items-center justify-between mb-1.5">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs font-medium text-primary-600 hover:text-primary-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-500 rounded">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <x-text-input id="password" class="block w-full pr-10" name="password"
                              required autocomplete="current-password"
                              x-bind:type="show ? 'text' : 'password'" />
                <button type="button" @click="show = !show"
                        :aria-label="show ? 'Hide password' : 'Show password'"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-400 hover:text-neutral-600 transition-colors">
                    {{-- Eye icon (show) --}}
                    <svg x-show="!show" aria-hidden="true" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{-- Eye-off icon (hide) --}}
                    <svg x-show="show" x-cloak aria-hidden="true" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Remember me --}}
        <div>
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-neutral-300 text-primary-600 shadow-sm focus:ring-primary-500 cursor-pointer">
                <span class="ms-2 text-sm text-neutral-600 group-hover:text-neutral-900 transition-colors">
                    Remember me
                </span>
            </label>
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center py-2.5" x-bind:disabled="loading">
            <span x-show="!loading">Sign in</span>
            <span x-show="loading" x-cloak class="inline-flex items-center gap-2">
                <svg aria-hidden="true" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Signing in…
            </span>
        </x-primary-button>

    </form>

</x-guest-layout>
