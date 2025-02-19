<x-app-layout>
    <div style="padding: 15px;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 5px;">
            <div
                style="background-color: white; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 15px; color: #1a202c;">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #e2e8f0; padding-bottom: 16px;">
                        <h2 style="font-weight: 600; font-size: 20px; color: #2d3748; margin: 0;">
                            {{ __('OLT List') }}
                        </h2>
                    </div>

                    <!-- Scrollable container -->
                    <div
                        style="height: 500px; overflow-y: auto; border: 1px solid #cbd5e0; border-radius: 8px; padding: 16px; background-color: #f9fafb;">
                        <section>
                            @php
                                $headers = [
                                    'olt_device' => 'OLT Device',
                                    'description' => 'Description',
                                    'action' => 'Action'
                                ];
                                $dropdownActions = [];
                                $dltAllbtn = [];
                                $tableActions = ['edit' => 'olt-device.edit', 'delete-item' => 'olt-device.destroy'];
                                $addButton = ['Add OLT Device', 'olt-device.create'];

                                $customMessage = [
                                    'success' => '',
                                    'delete' => 'This User will be permanently deleted if you proceed.',
                                ];
                            @endphp
                            <x-table :headers="$headers" :data="$data" title="OLT Device" :dropdown="$dropdownActions"
                                :actions="$tableActions" tablename="OLT Device" :addbtn="$addButton"
                                :searchField="false" :dltAllbtn="$dltAllbtn" itemName="Area"
                                :message="$customMessage" />
                        </section>
                    </div>
                    <!-- End Scrollable container -->
                </div>
            </div>
        </div>
    </div>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    // Event listener for delete confirmation using Swal
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This OLT Device will be permanently deleted if you proceed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
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
        axios.delete(`/olt-device/${id}`)
            .then(response => {
                // Show success alert
                Swal.fire('Deleted!', 'The OLT Device has been deleted.', 'success');
                // Reload or update the page
                location.reload();
            })
            .catch(error => {
                // Handle errors (if any)
                Swal.fire('Error!', 'There was an issue deleting the OLT Device.', 'error');
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