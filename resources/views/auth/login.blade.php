<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status style="margin-bottom: 16px;" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background: #f9f9f9;">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: 12px;">
            <x-input-label for="email" :value="__('Email')" style="display: block; font-weight: bold; margin-bottom: 4px;" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" />
            <x-input-error :messages="$errors->get('email')" style="color: red; margin-top: 4px;" />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 12px;">
            <x-input-label for="password" :value="__('Password')" style="display: block; font-weight: bold; margin-bottom: 4px;" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" />
            <x-input-error :messages="$errors->get('password')" style="color: red; margin-top: 4px;" />
        </div>

        <!-- Remember Me -->
        <div style="margin-bottom: 12px; display: flex; align-items: center;">
            <input id="remember_me" type="checkbox" name="remember" style="margin-right: 8px;">
            <label for="remember_me" style="font-size: 14px; color: #555;">{{ __('Remember me') }}</label>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 14px; color: #007bff; text-decoration: none;">{{ __('Forgot your password?') }}</a>
            @endif

            <x-primary-button style="background: #007bff; color: white; padding: 10px 16px; border: none; border-radius: 4px; cursor: pointer;">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
