<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8" style="max-height: 80vh; overflow-y: auto;">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Create Users') }}
                    </h2>

                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Account') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Add user account information") }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('user-management.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')" class="mt-4"></x-input-label>
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required></x-text-input>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"></x-input-error>
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Phone')" class="mt-4"></x-input-label>
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" required></x-text-input>
                                <x-input-error class="mt-2" :messages="$errors->get('phone')"></x-input-error>
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email address')" class="mt-4"></x-input-label>
                                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email')" required></x-text-input>
                                <x-input-error class="mt-2" :messages="$errors->get('email')"></x-input-error>
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" class="mt-4"></x-input-label>
                                <x-text-input name="password" type="password" class="mt-1 block w-full"></x-text-input>
                                <x-input-error class="mt-2" :messages="$errors->get('password')"></x-input-error>
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Password confirm')" class="mt-4"></x-input-label>
                                <x-text-input name="password_confirmation" type="password" class="mt-1 block w-full"></x-text-input>
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')"></x-input-error>
                            </div>

                            <div>
                                <x-input-label for="role" :value="__('Role')" class="mt-4"></x-input-label>
                                <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role')" required></x-text-input>
                                <x-input-error class="mt-2" :messages="$errors->get('role')"></x-input-error>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-10">{{ __('') }}</h2>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-14">
                                {{ __("User's Limitations") }}
                            </p>
                        </div>

                        <div class="grid grid-cols-4 gap-5">
                            @php
                                $permissions = [
                                    'dashboard_create',
                                    'dashboard_edit',
                                    'dashboard_delete',
                                    'dashboard_view',
                                    'packages_create',
                                    'packages_edit',
                                    'packages_delete',
                                    'packages_view',
                                    'customer_create',
                                    'customer_edit',
                                    'customer_delete',
                                    'customer_view',
                                    'service_detail_create',
                                    'service_detail_edit',
                                    'service_detail_delete',
                                    'service_detail_view',
                                    'transaction_create',
                                    'transaction_edit',
                                    'transaction_delete',
                                    'transaction_view',
                                    'router_create',
                                    'router_edit',
                                    'router_delete',
                                    'router_view',
                                    'user_management_create',
                                    'user_management_edit',
                                    'user_management_delete',
                                    'user_management_view',
                                    'tickets_create',
                                    'tickets_edit',
                                    'tickets_delete',
                                    'tickets_view',
                                    'dashboard_table',
                                    'package_table',
                                    'customer_table',
                                    'service_detail_table',
                                    'transaction_table',
                                    'router_table',
                                    'user_management_table',
                                    'ticket_table',
                                ];
                            @endphp

                            @foreach($permissions as $permission)
                                <div>
                                    <x-input-label :for="$permission" :value="__(ucwords(str_replace('_', ' ', $permission)))" class="mt-4"></x-input-label>
                                    <input id="{{ $permission }}" name="{{ $permission }}" type="checkbox" value="1" class="mt-1">
                                    <x-input-error class="mt-2" :messages="$errors->get($permission)"></x-input-error>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-4 col-span-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')