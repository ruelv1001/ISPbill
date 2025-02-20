<section style="max-width: 500px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <header>
        <h2 style="font-size: 20px; font-weight: bold; color: #333;">{{ __('Profile Information') }}</h2>
        <p style="margin-top: 8px; font-size: 14px; color: #666;">{{ __("Update your account's profile information and email address.") }}</p>
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

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">{{ __('Save') }}</button>
            <button type="button" onclick="document.getElementById('changePassModal').style.display='block'" style="background-color: #f44336; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">{{ __('Change Password') }}</button>
        </div>
    </form>
</section>

<!-- Change Password Modal -->
<div id="changePassModal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4);">
    <div style="background: white; margin: 10% auto; padding: 20px; width: 300px; border-radius: 8px; text-align: center;">
        <h3 style="margin-bottom: 15px;">Change Password</h3>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            <input type="password" name="current_password" placeholder="Current Password" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <input type="password" name="new_password" placeholder="New Password" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer;">Update</button>
            <button type="button" onclick="document.getElementById('changePassModal').style.display='none'" style="background-color: #777; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
        </form>
    </div>
</div>
