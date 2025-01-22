<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                        <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                            {{ __('Create Area') }}
                        </h2>

                    <form method="post" action="{{ route('olt-device.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">{{ __('OLT') }}</h2>
                                <p class="mt-1 text-sm text-gray-600">{{ __("Create a new OLT Device") }}</p>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="olt_device" :value="__('OLT Device')"></x-input-label>
                                    <x-text-input id="olt_device" name="olt_device" type="text" class="mt-1  md:text-sm block w-full" :value="old('olt_device')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('olt_device')"></x-input-error>
                                </div>
                                <div>
                                    <x-input-label for="description" :value="__('Description')" class="mt-4"></x-input-label>
                                    <textarea name="description" class="px-3 py-3 mt-1 rounded-lg border-gray-300 md:text-sm block w-full" rows="5"></textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')"></x-input-error>
                                </div>



                                <div class="flex items-center gap-4 mt-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
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
