<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Customer List') }}
                        </h2>


<div class="flex space-x-2">
    <a href="{{ route('area-location.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ __('Refresh') }}
    </a>
    <a href="{{ route('area-location.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ __('Area') }}
    </a>
    <a href="{{ route('olt-device.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ __('OLT') }}
    </a>
    <a href="{{ route('pon.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ __('PON') }}
    </a>
    <a href="{{ route('nap.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ __('NAP') }}
    </a>
    <a href="{{ route('port.index') }}"
        class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
        {{ __('Port') }}
    </a>
</div>

                    </div>
                    <div>
                        <section>
                            @php
$headers = [
    'id' => 'ID',
    'name' => 'Name',
    'active_due_date' => 'Expire',
    'status' => 'Status',
    'area' => 'area',
    'log_info' => 'Last login/Last logout',
    'action' => ''
];
$dropdownActions = ['Lock Selected' => 'lock'];
$dltAllbtn = ["Lock Selected", "users.bulk-lock"];
$tableActions = ['pay' => 'paybill.create', 'edit' => 'users.edit', 'delete-item' => 'users.destroy'];
$addButton = ['Add Customer', 'users.create'];
$customMessage = [
    'success' => '',
    'delete' => 'This User will be permanently deleted if you proceed.',
];
                            @endphp
                            <x-table :headers="$headers" :data="$users" title="" :dropdown="$dropdownActions" :actions="$tableActions"
                                tablename="user" :addbtn="$addButton" :filters="$userFilter" :searchField="true" :dltAllbtn="$dltAllbtn"
                                itemName="User" :message="$customMessage" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" x-show="open">
        <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-4 border-b">
                <h3 class="text-xl font-semibold">Payment Details</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <div class="py-4">
                <form method="post" action="{{ route('paybill.store') }}" class="space-y-1">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="hidden">
                                <x-input-label for="user_id" :value="__('Customer name')" class="mt-4" />
                                <x-text-input id="user_id" name="user_id" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $user->id ?? ''   }}" />
                            </div>
                            <div>
                                <x-input-label for="name" :value="__('Customer name')" class="mt-4" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $user->detail->name ?? '' }}" readonly />
                            </div>

                            <div>
                                <x-input-label for="package_name" :value="__(key: 'Package name')" class="mt-4" />
                                <x-text-input id="package_name" name="package_name" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $user->detail->package_name ?? '' }}" readonly />
                            </div>

                            <div>
                                <x-input-label for="package_price" :value="__(key: 'Package price')" class="mt-4" />
                                <x-text-input id="package_price" name="package_price" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $user->detail->package_price ?? '' }}" disabled />
                            </div>
                        </div>

                        <div>
                            <div>
                                <x-input-label for="payment_amount" :value="__(key: 'Amount Pay')" class="mt-4" />
                                <x-text-input id="payment_amount" name="payment_amount" type="number" class="mt-1 block w-full bg-gray-100" value="{{ $user->detail->package_price ?? '' }}" required />
                            </div>

                            <div>
                                <x-input-label for="payment_method" :value="__('Payment Method')" class="mt-4" />
                                <select id="payment_method" name="payment_method" class="mt-1 block w-full bg-gray-100" required onchange="toggleRefCode()">
                                    <option value="">Select a payment method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Maya">Maya</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div id="ref_code_container" class="mt-4 hidden">
                                <x-input-label for="ref_code" :value="__('Reference Code')" />
                                <x-text-input id="ref_code" name="ref_code" type="text" class="mt-1 block w-full bg-gray-100" placeholder="Enter Reference Code" />
                            </div>

                            <div>
                                <x-input-label for="remarks" :value="__(key: 'Remarks')" class="mt-4" />
                                <x-text-input id="remarks" name="remarks" type="text" class="mt-1 block w-full bg-gray-100" required />
                            </div>

                            <div class="flex items-center gap-4 mt-4">
                                <x-primary-button>{{ __('Pay') }}</x-primary-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@include('sweetalert::alert')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    function openPaymentModal() {
        document.getElementById('payment-modal').classList.remove('hidden');
        // Add logic to fetch user data and populate the form
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').classList.add('hidden');
    }

    function toggleRefCode() {
        const paymentMethod = document.getElementById('payment_method').value;
        const refCodeContainer = document.getElementById('ref_code_container');

        if (['Gcash', 'Maya', 'Bank Transfer'].includes(paymentMethod)) {
            refCodeContainer.classList.remove('hidden');
        } else {
            refCodeContainer.classList.add('hidden');
        }
    }

    window.addEventListener('updatePaginationUrl', function (event) {
        const url = new URL(window.location);
        url.searchParams.set('page', event.detail.page);
        history.pushState(null, '', url);
    });

    window.addEventListener('reloadPage', function () {
        location.reload();
    });

    document.addEventListener('livewire:load', () => {
        const bulkLockForm = document.getElementById('bulk-lock-form');
        const bulkUserIdsInput = document.getElementById('bulk-user-ids');

        Livewire.on('updateSelectedUsers', (selectedUserIds) => {
            bulkUserIdsInput.value = selectedUserIds.join(',');
        });
    });
    function openPaymentModal(userId) {
            fetch(`/get-user/${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('user_id').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('package_name').value = data.package_name;
                    document.getElementById('package_price').value = data.package_price;
                    document.getElementById('payment_amount').value = data.package_price;
                    document.getElementById('payment-modal').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }
</script>
<script>
    // Event listener for delete confirmation using Swal
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be permanently deleted if you proceed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed to delete the user
                deleteUser(id);
            }
        });
    }

    // Function to send AJAX delete request
    function deleteUser(id) {
            // Log the start of the delete operation
            console.log(`Attempting to delete user with ID: ${id}`);

            // Perform the delete request using AJAX
            axios.delete(`/users/${id}`)
                .then(response => {
                    // Log success
                    console.log(`User with ID: ${id} deleted successfully. Response:`, response.data);

                    // Show success alert
                    Swal.fire('Deleted!', 'The user has been deleted.', 'success');

                    // Option 1: Reload the page
                    location.reload();

                    // Option 2: Remove the user from the DOM without reloading
                    // document.getElementById(`user-${id}`).remove();
                })
                .catch(error => {
                    // Log the error
                    console.error(`Error deleting user with ID: ${id}. Error:`, error);

                    // Handle errors (if any)
                    if (error.response && error.response.status === 400) {
                        Swal.fire('Warning!', error.response.data.message, 'warning');
                    }
                    if (error.response && error.response.status === 405) {
                             Swal.fire('Warning!', error.response.data.message, 'warning');
                    }

                });
        }
</script>
