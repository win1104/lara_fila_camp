<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-mary-form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex mt-4">
            <x-mary-button class="w-full btn-success" type="submit">
                {{ __('Log in') }}
            </x-mary-button>
        </div>
    </x-mary-form>

    <!-- Or continue with -->
    <div class="relative mt-4">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">
                {{ __('Or continue with') }}
            </span>
        </div>
    </div>

    <!-- google login -->
    <div class="flex mt-4">
        <a class="w-1/2">
            <x-mary-button label="Google" icon="o-user" class="w-full btn-ghost"/>
        </a>
        <a class="w-1/2">
            <x-mary-button label="Facebook" icon="o-user" class="w-full btn-ghost"/>
        </a>
    </div>


    <!-- Register -->
    <div class="mt-8 text-center w-full" separator>
        <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Don\'t have an account? ') }} <span class="text-success text-md font-bold">{{ __('Sign up') }}</span>
        </a>
    </div>
    {{-- <div class="flex mt-2">
        <x-mary-button class="w-full btn-neutral" link="{{ route('register') }}">
            {{ __('Sign up') }}
        </x-mary-button>
    </div> --}}
</x-guest-layout>
