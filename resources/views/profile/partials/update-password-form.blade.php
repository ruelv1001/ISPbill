<section style="max-width: 500px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <header>
        <h2 style="font-size: 20px; font-weight: bold; color: #333;">{{ __('Update Password') }}</h2>
        <p style="margin-top: 8px; font-size: 14px; color: #666;">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="margin-top: 24px;">
        @csrf
        @method('put')

        <div style="margin-top: 16px;">
            <label for="current_password" style="font-weight: bold; color: #333;">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                style="margin-top: 8px; display: block; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            @if ($errors->updatePassword->get('current_password'))
                <p style="color: red; font-size: 12px;">{{ $errors->updatePassword->get('current_password')[0] }}</p>
            @endif
        </div>

        <div style="margin-top: 16px;">
            <label for="password" style="font-weight: bold; color: #333;">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                style="margin-top: 8px; display: block; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            @if ($errors->updatePassword->get('password'))
                <p style="color: red; font-size: 12px;">{{ $errors->updatePassword->get('password')[0] }}</p>
            @endif
        </div>

        <div style="margin-top: 16px;">
            <label for="password_confirmation" style="font-weight: bold; color: #333;">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                style="margin-top: 8px; display: block; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            @if ($errors->updatePassword->get('password_confirmation'))
                <p style="color: red; font-size: 12px;">{{ $errors->updatePassword->get('password_confirmation')[0] }}</p>
            @endif
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">{{ __('Save') }}</button>
            @if (session('status') === 'password-updated')
                <p style="color: #4CAF50; font-size: 14px; margin-top: 5px;">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
