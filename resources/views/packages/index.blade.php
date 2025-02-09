<x-app-layout>
    <div style="padding: 24px;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            <div
                style="background-color: #ffffff; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden;">
                <div style="padding: 24px; color: #1a202c;">
                    @if(session('success'))
                        <div
                            style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 16px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 4px; margin-bottom: 16px;">
                            {{ session('error') }}
                        </div>
                    @endif




                    @if (auth()->user()->isAdmin())
                                        <section>
                                            @php
                                                $headers = [
                                                    'name' => 'name',
                                                    'price' => 'Price',
                                                    'created_at' => 'Date Created',
                                                    'action' => 'Action'
                                                ];
                                                $dropdownActions = [];
                                                $dltAllbtn = [];
                                                $tableActions = ['edit' => 'packages.edit', 'delete-item' => 'packages.destroy'];
                                                $addButton = ['Add package', 'packages.create'];

                                                $customMessage = [
                                                    'success' => '',
                                                    'delete' => 'This User will be permanently deleted if you proceed.',
                                                ];

                                            @endphp
                                            <x-table :headers="$headers" :data="$data" title="Port" :dropdown="$dropdownActions"
                                                :actions="$tableActions" tablename="Port" :addbtn="$addButton" :searchField="false"
                                                :dltAllbtn="$dltAllbtn" itemName="Area" :message="$customMessage" />
                                        </section>
                    @endif
                    @if (auth()->user()->isUser())
                        <livewire:user-package-table />
                    @endif

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
            text: 'This Package will be permanently deleted if you proceed.',
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
        axios.delete(`/packages/${id}`)
            .then(response => {
                // Show success alert
                Swal.fire('Deleted!', 'The Package has been deleted.', 'success');
                // Reload or update the page
                location.reload();
            })
            .catch(error => {
                // Handle errors (if any)
                Swal.fire('Error!', 'There was an issue deleting the Port.', 'error');
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
