<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 16px 32px;">
                    @if(session('error'))
                        <div style="color: red; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #d1d5db; padding-bottom: 16px;">
                        {{ __('Edit Router') }}
                    </h2>

                    <form method="post" action="{{ route('router.update', $router->id) }}" style="margin-top: 24px; margin-bottom: 24px;">
                        @csrf
                        @method('patch')

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Router') }}</h2>
                                <p style="margin-top: 8px; font-size: 14px; color: #4b5563;">{{ __("Edit Mikrotik router details") }}</p>
                            </div>

                            <div>
                                <div>
                                    <label for="name" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Router name') }}</label>
                                    <input id="name" name="name" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ $router->name }}" disabled>
                                </div>
                                
                                <div style="margin-top: 16px;">
                                    <label for="location" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Location') }}</label>
                                    <input id="location" name="location" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ $router->location }}">
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('location') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div style="margin-top: 16px;">
                                    <label for="ip" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Router IP') }}</label>
                                    <input id="ip" name="ip" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ $router->ip }}" required>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('ip') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div style="margin-top: 16px;">
                                    <label for="username" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Router username') }}</label>
                                    <input id="username" name="username" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ $router->username }}" required>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('username') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div style="margin-top: 16px;">
                                    <label for="password" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Router password') }}</label>
                                    <input id="password" name="password" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ $router->password }}" required>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('password') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px;">
                                    <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')