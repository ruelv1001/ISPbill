<x-app-layout>
    <div style="padding: 2px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 5px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 5px; color: #1f2937;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        <h2 style="font-size: 20px; font-weight: 600; color: #374151; line-height: 1.25;">
                            {{ __('User Role List') }}
                        </h2>
                    </div>
                    <div>
                        <section>
                            @php
                                $headers = [
                                    'role' => 'Area',
                                    'description' => 'Description',
                                    'action' => ''
                                ];
                                $dropdownActions = ['Lock Selected' => 'lock']; // Add lock action to dropdown
                                $dltAllbtn = ["Lock Selected", "users.bulk-lock"];
                                $tableActions = ['edit' => 'user-type.edit', 'delete-item' => 'user-type.destroy'];
                                $addButton = ['Add User Role', 'user-type.create'];
                                $customMessage = [
                                    'success' => '',
                                    'delete' => 'This User will be permanently deleted if you proceed.',
                                ];
                            @endphp
                            <x-table :headers="$headers" :data="$data" title="User Type" :dropdown="$dropdownActions"
                                :actions="$tableActions" tablename="User Role" :addbtn="$addButton" :filters="$areaFilter"
                                :searchField="false" :dltAllbtn="$dltAllbtn" itemName="Area" :message="$customMessage" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('sweetalert::alert')


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

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    // Event listener for delete confirmation using Swal
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This Role will be permanently deleted if you proceed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonColor: '#d33',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed to delete the AreaLocation
                deleteAreaLocation(id);
            }
        });
    }

    // Function to send AJAX delete request
    function deleteAreaLocation(id) {
        // Perform the delete request using AJAX
        axios.delete(`/user-type/${id}`)
            .then(response => {
                // Show success alert
                Swal.fire('Deleted!', 'The User Type has been deleted.', 'success');
                // Reload or update the page
                location.reload();
            })
            .catch(error => {
                // Handle errors (if any)
                Swal.fire('Error!', 'There was an issue deleting the AreaLocation.', 'error');
            });
    }

    window.addEventListener('updatePaginationUrl', function (event) {
        const url = new URL(window.location);
        url.searchParams.set('page', event.detail.page);
        history.pushState(null, '', url);
    });

    window.addEventListener('reloadPage', function () {
        location.reload();
    });
</script>

