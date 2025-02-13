<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden;">
                <div style="padding: 16px 24px; max-height: 80vh; overflow-y: auto;">
                    @if(session('error'))
                        <div style="color: #e53e3e; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        {{ __('Create Users') }}
                    </h2>

                    <div>
                        <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Account') }}</h2>
                        <p style="margin-top: 8px; font-size: 14px; color: #6b7280;">
                            {{ __("Add user account information") }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('user-management.store') }}" style="margin-top: 24px; display: grid; gap: 24px;">
                        @csrf

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; ">
                            <div style="margin-right: 15px;">
                                <label for="name" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Name') }}</label>
                                <input id="name" name="name" type="text" style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; width: 100%;" value="{{ old('name') }}" required />
                                @error('name')
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div style="margin-right: 15px;">
                                <label for="phone" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Phone') }}</label>
                                <input id="phone" name="phone" type="text" style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; width: 100%;" value="{{ old('phone') }}" required />
                                @error('phone')
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div style="margin-right: 15px;">
                                <label for="email" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Email address') }}</label>
                                <input id="email" name="email" type="text" style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; width: 100%;" value="{{ old('email') }}" required />
                                @error('email')
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div style="margin-right: 15px;">
                                <label for="password" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Password') }}</label>
                                <input name="password" type="password" style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; width: 100%;" />
                                @error('password')
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div style="margin-right: 15px;">
                                <label for="password_confirmation" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Password confirm') }}</label>
                                <input name="password_confirmation" type="password" style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; width: 100%;" />
                                @error('password_confirmation')
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div style="margin-right: 15px;">
                                <label for="role" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Role') }}</label>
                                <select name="role" id="role" style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px; width: 100%;">
                                    @if ($userType && $userType->isNotEmpty())
                                        @foreach($userType as $utype)
                                            <option value="{{ $utype->role }}">{{ $utype->role }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No Role available</option>
                                    @endif
                                </select>
                                @error('role')
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div style="margin-right: 15px;">
                            <h2 style="font-size: 18px; font-weight: 500; color: #374151; margin-top: 24px;">{{ __("User's Limitations") }}</h2>
                        </div>

                        <div style="display: flex; gap: 16px; justify-content: flex-start;">
                            <button type="submit" style="background-color: #2d3748; color: white; padding: 12px 24px; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')
