<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden;">
                <div style="padding: 16px 24px; max-height: 80vh; overflow-y: auto;">
                    <x-slot name="header">
                        <h2 style="font-size: 20px; font-weight: 600; color: #374151;">
                            {{ $user->name }}
                        </h2>
                    </x-slot>

                    @if(session('error'))
                        <div style="color: #e53e3e; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        {{ __('Edit user') }}
                    </h2>

                    <div>
                        <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Account') }}</h2>
                        <p style="margin-top: 8px; font-size: 14px; color: #6b7280;">
                            {{ __("Edit user account information") }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('user-management.update', $user->id) }}" style="margin-top: 24px; display: grid; gap: 24px;">
                        @csrf
                        @method('patch')

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                            <div>
                                <div>
                                    <label for="user_id" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('User ID') }}</label>
                                    <input id="user_id" name="user_id" type="text" readonly
                                        style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; background-color: #f3f4f6; width: 100%;" value="{{ $user->id }}" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="name" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('User Name') }}</label>
                                    <input id="name" name="name" type="text"
                                        style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; background-color: #f3f4f6; width: 100%;" value="{{ $user->name }}" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="role" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Role') }}</label>
                                    <input id="role" name="role" type="text" 
                                        style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; background-color: #f3f4f6; width: 100%;" value="{{ $user->role }}" />
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        @error('role'){{ $message }}@enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="email" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Email address') }}</label>
                                    <input id="email" name="email" type="text"
                                        style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; background-color: #f3f4f6; width: 100%;" value="{{ $user->email }}" />
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        @error('email'){{ $message }}@enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="password" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Password') }}</label>
                                    <input name="password" type="password" 
                                        style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; width: 100%;" value="" />
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        @error('password'){{ $message }}@enderror
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="password_confirmation" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __('Password confirm') }}</label>
                                    <input name="password_confirmation" type="password" 
                                        style="margin-top: 8px; padding: 8px; border: 1px solid #d1d5db; width: 100%;" value="" />
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        @error('password_confirmation'){{ $message }}@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 style="font-size: 18px; font-weight: 500; color: #374151; margin-top: 24px;">{{ __("User's Limitations") }}</h2>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                            @foreach($permissions as $permission)
                                <div>
                                    <label for="{{ $permission }}" style="font-size: 14px; font-weight: 500; color: #374151;">{{ __(ucwords(str_replace('_', ' ', $permission))) }}</label>
                                    <input id="{{ $permission }}" name="{{ $permission }}" type="checkbox" value="1"
                                        style="margin-top: 8px;" {{ old($permission, $userLimit->$permission) == 1 ? 'checked' : '' }} />
                                    <div style="margin-top: 4px; color: #e53e3e; font-size: 12px;">
                                        @error($permission){{ $message }}@enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div style="display: flex; gap: 16px; justify-content: flex-start; margin-top: 16px;">
                            <button type="submit" style="background-color: #2d3748; color: white; padding: 12px 24px; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
