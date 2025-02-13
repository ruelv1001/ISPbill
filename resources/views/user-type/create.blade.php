<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 16px 32px; overflow-y: auto; max-height: 80vh;">
                    @if(session('error'))
                        <div style="color: red; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #d1d5db; padding-bottom: 16px;">
                        {{ __('Create Role') }}
                    </h2>

                    <form method="post" action="{{ route('user-type.store') }}" style="margin-top: 24px; margin-bottom: 24px;">
                        @csrf
                        <div>
                                <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('User Role') }}</h2>
                                <p style="margin-top: 8px; font-size: 14px; color: #4b5563;">
                                    {{ __("Create a new role") }}
                                </p>
                            </div>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    

                            <div>
                                <div>
                                    <label for="role" style="font-weight: 500; color: #374151; margin-bottom: 8px;">{{ __('Role') }}</label>
                                    <input id="role" name="role" type="text" style="margin-top: 8px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;" value="{{ old('role') }}" required>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('role') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label for="description" style="font-weight: 500; color: #374151; margin-top: 16px; margin-bottom: 8px;">{{ __('Description') }}</label>
                                    <textarea name="description" style="padding: 12px; margin-top: 8px; display: block; width: 100%; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;" rows="5"></textarea>
                                    <div style="color: red; font-size: 12px; margin-top: 4px;">
                                        @foreach ($errors->get('description') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <h2 style="font-size: 18px; font-weight: 500; color: #374151; margin-top: 24px;">{{ __("User's Limitations") }}</h2>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
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
                                                <label for="{{ $permission }}" style="font-weight: 500; color: #374151; margin-bottom: 8px;">
                                                    {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                </label>
                                                <div style="margin-top: 8px;">
                                                <input id="{{ $permission }}" name="{{ $permission }}" type="checkbox" value="1" style="vertical-align: middle; margin-left: 0; transform: scale(1.5);">
                                                </div>
                                                <div style="color: red; font-size: 12px; margin-top: 4px;">
                                                    @foreach ($errors->get($permission) as $error)
                                                        {{ $error }}
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
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
