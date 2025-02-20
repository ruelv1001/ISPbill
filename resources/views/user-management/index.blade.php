<x-app-layout>
    <div style="padding: 2px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 5px;">
            <div style="background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden;">
                <div style="padding: 5px; color: #374151;">
                    @if(session('success'))
                        <div style="color: green; font-size: 14px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="color: red; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        <h2 style="font-size: 20px; font-weight: 600; color: #374151;">
                            {{ __('Users') }}
                        </h2>
                        <div style="display: flex; align-items: center;">
                            @if (auth()->user()->isAdmin())
                                <form action="{{ route('due.user.disable') }}" method="post" style="display: none;">
                                    @csrf
                                    <button type="submit" style="background-color: #e11d48; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                                        {{ __('Disable all Customer with due') }}
                                    </button>
                                </form>

                                <a href="{{ route('user.download') }}" style="margin-left: 8px; display: inline-flex; align-items: center; padding: 8px 16px; background-color: #f59e0b; color: white; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase; text-decoration: none;">
                                    {{ __('Download') }}
                                </a>

                                <a href="{{ route('user-management.create') }}" style="margin-left: 8px; display: inline-flex; align-items: center; padding: 8px 16px; background-color: #2d3748; color: white; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase; text-decoration: none;">
                                    {{ __('Create') }}
                                </a>

                                <a href="{{ route('user-type.index') }}" style="margin-left: 8px; display: inline-flex; align-items: center; padding: 8px 16px; background-color: #2d3748; color: white; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase; text-decoration: none;">
                                    {{ __('User Type management') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div style="max-height: 600px; overflow-y: auto;">
                        <section>
                            @php
$headers = [
    'name' => 'Name',
    'role' => 'Role',
    'action' => 'Action'
];
$dropdownActions = ['Lock Selected' => 'lock']; 
$dltAllbtn = ["Lock Selected", "users.bulk-lock"];
$tableActions = ['edit' => 'user-management.edit', 'delete-item' => 'user-management.destroy'];
$addButton = ['Add User Role', 'user-management.create'];
$filterRoute = route('user-management.index');
$customMessage = [
    'success' => '',
    'delete' => 'This User will be permanently deleted if you proceed.',
];
                            @endphp
                            <x-table :headers="$headers" :data="$data" title="User Management" :dropdown="$dropdownActions"
                                :actions="$tableActions" tablename="User Role" :addbtn="$addButton" :filterRoute=$filterRoute
                                :filters="$areaFilter" :searchField="false" :dltAllbtn="$dltAllbtn"
                                itemName="Area" :message="$customMessage" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('sweetalert::alert')


