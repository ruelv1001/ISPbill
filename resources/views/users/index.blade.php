<x-app-layout>
    <div style="padding: 2px;">
        <div style="max-width: 1600px; margin: 0 auto; padding: 0 5px;">
            <div
                style="background-color: white; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 5px; color: #1a202c;">
                    <!-- Scrollable container -->
                    <div style="max-height: 80vh; overflow-y: auto;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #e2e8f0; padding-bottom: 16px;">
                            <h2 style="font-weight: 600; font-size: 20px; color: #2d3748; margin: 0;">
                                {{ __('Customer List') }}
                            </h2>

                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('area-location.index') }}"
                                    style="display: inline-flex; align-items: center; padding: 8px 12px; background-color: #2d3748; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none;">
                                    {{ __('Refresh') }}
                                </a>
                                <a href="{{ route('area-location.index') }}"
                                    style="display: inline-flex; align-items: center; padding: 8px 12px; background-color: #2d3748; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none;">
                                    {{ __('Area') }}
                                </a>
                                <a href="{{ route('olt-device.index') }}"
                                    style="display: inline-flex; align-items: center; padding: 8px 12px; background-color: #2d3748; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none;">
                                    {{ __('OLT') }}
                                </a>
                                <a href="{{ route('pon.index') }}"
                                    style="display: inline-flex; align-items: center; padding: 8px 12px; background-color: #2d3748; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none;">
                                    {{ __('PON') }}
                                </a>
                                <a href="{{ route('nap.index') }}"
                                    style="display: inline-flex; align-items: center; padding: 8px 12px; background-color: #2d3748; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none;">
                                    {{ __('NAP') }}
                                </a>
                                <a href="{{ route('port.index') }}"
                                    style="display: inline-flex; align-items: center; padding: 8px 12px; background-color: #2d3748; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 12px; text-transform: uppercase; text-decoration: none;">
                                    {{ __('Port') }}
                                </a>
                            </div>
                        </div>

                        <div>
                            <section>
                                @php
$headers = [
    'id' => 'Check All',
    'name' => 'Name',
    'active_due_date' => 'Expire',
    'area' => 'Area',
    'package_name' => 'Plan',
    'log_info' => 'Status',
    'remarks' => 'Remarks',
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
    </div>

    <!-- Payment Modal -->
    <div id="payment-modal"
     style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); display: none; overflow-y: auto; width: 100%; height: 100%;">
        <div style="position: relative; top: 10%; margin: auto; padding: 20px; width: 50%; max-width: 600px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);">

            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 2px solid #ddd;">
                <h3 style="font-size: 20px; font-weight: bold; color: #333;">Payment Details</h3>
                <button onclick="closePaymentModal()"
                        style="font-size: 24px; color: #888; border: none; background: none; cursor: pointer;">&times;
                </button>
            </div>

            <!-- Form -->
            <div style="padding-top: 15px;">
                <form method="post" action="{{ route('paybill.store') }}">
                    @csrf
                    <div style="display: flex; flex-wrap: wrap; gap: 20px;">

                        <!-- Left Column -->
                        <div style="flex: 1; min-width: 250px;">

                            <input id="user_id" name="user_id" type="hidden" value="{{ $user->id ?? '' }}">

                            <div style="margin-bottom: 20px; margin-right: 15px;">
                                <label for="name"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Customer Name') }}
                                </label>
                                <input id="name" name="name" type="text"
                                       value="{{ $user->detail->name ?? '' }}" readonly
                                       style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                            </div>

                            <div style="margin-bottom: 20px; margin-right: 15px;">
                                <label for="package_name"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Package Name') }}
                                </label>
                                <input id="package_name" name="package_name" type="text"
                                       value="{{ $user->detail->package_name ?? '' }}" readonly
                                       style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                            </div>

                            <div style="margin-bottom: 20px; margin-right: 15px;">
                                <label for="package_price"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Package Price') }}
                                </label>
                                <input id="package_price" name="package_price" type="text"
                                       value="{{ $user->detail->package_price ?? '' }}" disabled
                                       style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div style="flex: 1; min-width: 250px;">
                            <div style="margin-bottom: 20px;">
                                <label for="payment_amount"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Amount to Pay') }}
                                </label>
                                <input id="payment_amount" name="payment_amount" type="number"
                                       value="{{ $user->detail->package_price ?? '' }}" required
                                       style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="payment_method"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Payment Method') }}
                                </label>
                                <select id="payment_method" name="payment_method" required onchange="toggleRefCode()"
                                        style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                                    <option value="">Select a payment method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Maya">Maya</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div id="ref_code_container" style="margin-bottom: 20px; display: none;">
                                <label for="ref_code"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Reference Code') }}
                                </label>
                                <input id="ref_code" name="ref_code" type="text" placeholder="Enter Reference Code"
                                       style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="remarks"
                                       style="font-weight: 500; color: #374151; margin-bottom: 20px;">
                                    {{ __('Remarks') }}
                                </label>
                                <input id="remarks" name="remarks" type="text" required
                                       style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f5f5f5;">
                            </div>

                            <div style="text-align: right;">
                                <button id="payment-button" type="submit"
                                        style="background: #007bff; color: white; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                                    Pay
                                </button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function openPaymentModal(userId) {
        // First make sure the modal is visible
        document.getElementById('payment-modal').style.display = 'block';

        fetch(`/get-user/${userId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('user_id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('package_name').value = data.package_name;
                document.getElementById('package_price').value = data.package_price;
                document.getElementById('payment_amount').value = data.package_price;

                const paymentAmount = document.getElementById('payment_amount');
                const paymentMethod = document.getElementById('payment_method');
                const paymentButton = document.getElementById('payment-button');
                const refCodeContainer = document.getElementById('ref_code_container');

                if (data.status === 'new') {
                    paymentAmount.value = 0;
                    paymentAmount.readOnly = true;
                    paymentMethod.innerHTML = '<option value="Activate">Activate</option>';
                    paymentButton.textContent = 'Activate';
                } else {
                    paymentAmount.value = data.package_price;
                    paymentAmount.readOnly = false;
                    paymentMethod.innerHTML = `
                        <option value="">Select a payment method</option>
                        <option value="Cash">Cash</option>
                        <option value="Gcash">Gcash</option>
                        <option value="Maya">Maya</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    `;
                    paymentButton.textContent = 'Pay';
                }

                // Update reference code visibility based on selected payment method
                toggleRefCode();
            })
            .catch(error => console.error('Error:', error));
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').style.display = 'none';
    }

    function toggleRefCode() {
        const paymentMethod = document.getElementById('payment_method').value;
        const refCodeContainer = document.getElementById('ref_code_container');

        if (paymentMethod === 'Cash' || paymentMethod === 'Activate' || paymentMethod === '') {
            refCodeContainer.style.display = 'none';
        } else {
            refCodeContainer.style.display = 'block';
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteUser(id);
            }
        });
    }

    function deleteUser(id) {
        axios.delete(`/users/${id}`)
            .then(response => {
                if (response.status === 200) {
                    Swal.fire('Deleted!', response.data.message, 'success')
                        .then(() => {
                            location.reload();
                        });
                }
            })
            .catch(error => {
                // Handle specific error messages from the backend
                const errorMessage = error.response?.data?.message || 'Could not delete user.';
                Swal.fire('Error!', errorMessage, 'error');
            });
    }
</script>
