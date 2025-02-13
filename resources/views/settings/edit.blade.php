<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 16px; padding-top: 32px;">
                    @if(session('success'))
                        <div style="background-color: #d1fae5; color: #065f46; padding: 8px 16px; border-radius: 8px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background-color: #fee2e2; color: #dc2626; padding: 8px 16px; border-radius: 8px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-weight: 600; font-size: 20px; color: #374151; line-height: 1.25; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        {{ __('Application Settings') }}
                    </h2>

                    <form method="post" action="{{ route('settings.update', $settings ? $settings->id : null) }}" style="margin-top: 24px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                        @csrf
                        @method('patch')

                        <div>
                            <h2 style="font-size: 18px; font-weight: 500; color: #1f2937;">{{ __('Mikrotik') }}</h2>
                            <p style="margin-top: 4px; font-size: 14px; color: #6b7280;">{{ __("Update your Mikrotik router information.") }}</p>
                        </div>

                        <div>
                            <div>
                                <label for="router_ip" style="font-weight: 500; color: #374151; display: block; margin-top: 16px;">{{ __('Mikrotik IP') }}</label>
                                <input type="text" id="router_ip" name="router_ip" value="{{ old('router_ip', $settings ? $settings->router_ip : '') }}" required style="margin-top: 4px; padding: 8px 16px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;">
                                <div style="color: #dc2626; margin-top: 4px;">@error('router_ip') {{ $message }} @enderror</div>
                            </div>

                            <div>
                                <label for="router_username" style="font-weight: 500; color: #374151; display: block; margin-top: 16px;">{{ __('Mikrotik username') }}</label>
                                <input type="text" id="router_username" name="router_username" value="{{ old('router_username', $settings ? $settings->router_username : '') }}" required style="margin-top: 4px; padding: 8px 16px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;">
                                <div style="color: #dc2626; margin-top: 4px;">@error('router_username') {{ $message }} @enderror</div>
                            </div>

                            <div>
                                <label for="router_password" style="font-weight: 500; color: #374151; display: block; margin-top: 16px;">{{ __('Mikrotik password') }}</label>
                                <input type="password" id="router_password" name="router_password" value="{{ old('router_password', $settings ? $settings->router_password : '') }}" required style="margin-top: 4px; padding: 8px 16px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;">
                                <div style="color: #dc2626; margin-top: 4px;">@error('router_password') {{ $message }} @enderror</div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 16px; margin-top: 24px;">
                                <button type="submit" style="padding: 8px 16px; background-color: #4b5563; color: white; border-radius: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
