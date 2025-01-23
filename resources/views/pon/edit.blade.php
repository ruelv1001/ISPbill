<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <x-slot name="header">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $pon->pon }}
                        </h2>
                    </x-slot>

                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2
                        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Edit PON') }}
                    </h2>

                    <form method="post" action="{{ route('pon.update', $pon->id) }}"
                        class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('PON') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Edit PON") }}
                                </p>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="pon" :value="__('PON')" class="mt-4"></x-input-label>
                                    <x-text-input id="pon" name="pon" type="text" required
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ old('pon', $pon->pon) }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="description" name="description" type="text" required
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ old('description', $pon->description) }}"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')"></x-input-error>
                                </div>

                                <div class="flex items-center gap-4 mt-4">
                                    <x-primary-button>{{ __('Update') }}</x-primary-button>
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
