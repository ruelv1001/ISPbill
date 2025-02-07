<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8 overflow-y-auto" style="max-height: 80vh;"> <!-- Added overflow-y-auto and max-height -->
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Create Role') }}
                    </h2>

                    <form method="post" action="{{ route('user-type.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-flex-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">{{ __('User Role') }}</h2>
                                <p class="mt-1 text-sm text-gray-600">{{ __("Create a new role") }}</p>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="role" :value="__('Role')"></x-input-label>
                                    <x-text-input id="role" name="role" type="text" class="mt-1  md:text-sm block w-full" :value="old('role')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('role')"></x-input-error>
                                </div>
                                <div>
                                    <x-input-label for="description" :value="__('Description')" class="mt-4"></x-input-label>
                                    <textarea name="description" class="px-3 py-3 mt-1 rounded-lg border-gray-300 md:text-sm block w-full" rows="5"></textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')"></x-input-error>
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