<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Packages') }}
                        </h2>
                        @if (auth()->user()->isAdmin())
                            <x-create-button url="{{ route('packages.create') }}"></x-create-button>
                        @endif
                    </div>
                    <div>
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

