<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 16px 32px;">
                    <x-slot name="header">
                        <h2 style="font-size: 20px; font-weight: 600; color: #374151; padding-bottom: 16px; border-bottom: 2px solid #d1d5db;">
                            {{ $areaLocation->area }}
                        </h2>
                    </x-slot>

                    @if(session('error'))
                        <div style="color: red; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #d1d5db; padding-bottom: 16px;">
                        {{ __('Edit Area') }}
                    </h2>

                    <form method="post" action="{{ route('area-location.update', $areaLocation->id) }}" style="margin-top: 24px; padding-bottom: 24px;">
                        @csrf
                        @method('patch')

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Area') }}</h2>
                                <p style="margin-top: 8px; font-size: 14px; color: #4b5563;">{{ __("Edit Area") }}</p>
                            </div>

                            <div>
                                <div style="margin-top: 16px;">
                                    <label for="area" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Area') }}</label>
                                    <input id="area" name="area" type="text" required
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ old('area', $areaLocation->area) }}">
                                </div>

                                <div style="margin-top: 16px;">
                                    <label for="description" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Description') }}</label>
                                    <input id="description" name="description" type="text" required
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ old('description', $areaLocation->description) }}">
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('description') as $error)
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
