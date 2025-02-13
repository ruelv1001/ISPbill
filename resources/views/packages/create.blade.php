<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 16px 32px;">
                    @if(session('error'))
                        <div style="color: red; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #d1d5db; padding-bottom: 16px;">
                        {{ __('Create Package') }}
                    </h2>

                    <form method="post" action="{{ route('packages.store') }}" style="margin-top: 24px;">
                        @csrf

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Package') }}</h2>
                                <p style="margin-top: 8px; font-size: 14px; color: #4b5563;">{{ __("Add package name and price") }}</p>
                            </div>

                            <div>
                                <div>
                                    <label for="router_id" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Select router') }}</label>
                                    <select name="router_id" id="router_id" style="margin-top: 8px; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;">
                                        <option value="">{{ __('Select Mikrotik router') }}</option>
                                        @foreach ($routers as $router)
                                            <option value="{{ $router->id }}">{{ $router->name }}</option>
                                        @endforeach 
                                    </select>
                                </div>

                                <div style="margin-top: 16px;">
                                    <label for="name" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Package name') }}</label>
                                    <input id="name" name="name" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ old('name') }}" required>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('name') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div style="margin-top: 16px;">
                                    <label for="price" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Package price') }}</label>
                                    <input id="price" name="price" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ old('price') }}" required>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('price') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px;">
                                    <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                                        {{ __('Save') }}
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

