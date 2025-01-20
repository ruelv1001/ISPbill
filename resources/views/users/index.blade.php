<x-app-layout>
    <section>
        @php
            $headers = [
                'id' => 'ID',
                // Empty string for just the icon
                'name' => 'Name',
                'email' => 'Email',
                'status' => 'Status',
                'uptime_info' => 'Up-time/Down-Time',
                'log_info' => 'Last login/Last logout',
                'action' => ''
            ];
            $dropdownActions = ['Lock Selected' => 'lock']; // Add lock action to dropdown
            $dltAllbtn = ["Lock Selected", "users.bulk-lock"];
            $tableActions = ['view' => 'paybill.create', 'edit' => 'users.edit', 'delete' => 'users.bulk-lock'];
            $addButton = ['Add User', 'users.create'];
            $customMessage = [
                'success' => '',
                'delete' => 'This User will be permanently deleted if you proceed.',
            ];

        @endphp
        <x-table :headers="$headers" :data="$users" title="Users" :dropdown="$dropdownActions" :actions="$tableActions"
            tablename="user" :addbtn="$addButton" :filters="$userFilter" :searchField="true" :dltAllbtn="$dltAllbtn"
            itemName="User" :message="$customMessage" />
    </section>


</x-app-layout>
@include('sweetalert::alert')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script>
    window.addEventListener('updatePaginationUrl', function (event) {
        const url = new URL(window.location);
        url.searchParams.set('page', event.detail.page);
        history.pushState(null, '', url);
    });

    window.addEventListener('reloadPage', function () {

        location.reload();
    });
</script>
<script>
    document.addEventListener('livewire:load', () => {
        const bulkLockForm = document.getElementById('bulk-lock-form');
        const bulkUserIdsInput = document.getElementById('bulk-user-ids');

        Livewire.on('updateSelectedUsers', (selectedUserIds) => {
            bulkUserIdsInput.value = selectedUserIds.join(',');
        });
    });
</script>
