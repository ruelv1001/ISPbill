<section
    style="max-width: 500px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <header>
        <h2 style="font-size: 20px; font-weight: bold; color: #333;">{{ __('Profile Information') }}</h2>
        <p style="margin-top: 8px; font-size: 14px; color: #666;">
            {{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="margin-top: 24px;">
        @csrf
        @method('patch')

        <div style="margin-top: 16px;">
            <label for="name" style="font-weight: bold; color: #333;">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                style="margin-top: 8px; display: block; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"
                value="{{ old('name', $user->name) }}">
        </div>

        <div style="margin-top: 16px;">
            <label for="email" style="font-weight: bold; color: #333;">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" required autocomplete="username"
                style="margin-top: 8px; display: block; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"
                value="{{ old('email', $user->email) }}">
        </div>


    </form>
</section>

<!-- Change Password Modal -->
<div id="changePassModal"
    style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4);">
    <div
        style="background: white; margin: 10% auto; padding: 20px; width: 300px; border-radius: 8px; text-align: center;">
        <h3 style="margin-bottom: 15px;">{{ __('Update Password') }}</h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div>
                <x-input-label for="current_password" :value="__('Current Password')" />
                <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full"
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                <button type="button" onclick="document.getElementById('changePassModal').style.display='none'"
                    style="background-color: #777; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
            </div>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </form>
    </div>
</div>