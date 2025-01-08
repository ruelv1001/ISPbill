<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <x-slot name="header">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $user->name }}
                        </h2>
                    </x-slot>
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2
                        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Edit user') }}
                    </h2>

                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Account') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Edit user account information") }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('user-management.update', $user->id) }}"
                        class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-4 gap-4">
                            <div >
                                <div>
                                    <x-input-label for="user_id" :value="__('User ID')" class="mt-4"
                                        ></x-input-label>
                                    <x-text-input id="user_id" name="user_id" type="text" readonly
                                        class="mt-1 block w-full bg-gray-100" value="{{ $user->id }}"></x-text-input>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="name" :value="__('User  Name')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="name" name="name" type="text"
                                        class="mt-1 block w-full bg-gray-100" value="{{ $user->name }}"></x-text-input>
                                </div>
                            </div>

                                <div>
                                    <div>
                                        <x-input-label for="User Type" :value="__('Role')" class="mt-4"></x-input-label>
                                        <x-text-input id="role" name="role" type="text" class="mt-1 block w-full bg-gray-100"
                                            value="{{ $user->role }}"></x-text-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('emaroleil')"></x-input-error>
                                    </div>
                                </div>


                            <div>
                                <div>
                                    <x-input-label for="email" :value="__('Email address')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="email" name="email" type="text"
                                        class="mt-1 block w-full bg-gray-100" value="{{ $user->email }}"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')"></x-input-error>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="mt-4"></x-input-label>
                                    <x-text-input name="password" type="password" class="mt-1 block w-full"
                                        value=""></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('password')"></x-input-error>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Password confirm')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input name="password_confirmation" type="password" class="mt-1 block w-full"
                                        value=""></x-text-input>
                                    <x-input-error class="mt-2"
                                        :messages="$errors->get('password_confirmation')"></x-input-error>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-10">{{ __('') }}
                            </h2>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-14">
                                {{ __("User's Limitations") }}
                            </p>
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            @foreach($permissions as $permission)
                                <div>
                                    <x-input-label for="{{ $permission }}" :value="__(ucwords(str_replace('_', ' ', $permission)))" class="mt-4"></x-input-label>
                                    <select id="{{ $permission }}" name="{{ $permission }}" class="mt-1 block w-full">
                                        <option value="1" {{ old($permission, $userLimit->$permission) == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                        <option value="0" {{ old($permission, $userLimit->$permission) == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get($permission)"></x-input-error>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
