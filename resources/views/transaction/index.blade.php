<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Transactions') }}
                        </h2>
                    </div>

                    <!-- Scrollable Content Section -->
                    <div class="overflow-y-auto" style="max-height: 80vh;">
                        <!-- Transaction Summary Section -->
                        <div class="space-y-8">
                            <h2 class="text-2xl font-bold text-gray-800">Transaction Summary</h2>

                            <!-- Payment Method Summary -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">Totals by Payment Method</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                @foreach ($totalsByMethod as $method => $total)
                                                    <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                                        {{ $method }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                @foreach ($totalsByMethod as $total)
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                        Php {{ number_format($total, 2) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Daily Totals Summary -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">Totals by Day</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                @foreach ($totalsPerDay as $date => $total)
                                                    <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                                        {{ $date }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                @foreach ($totalsPerDay as $total)
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                        Php {{ number_format($total, 2) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Overall Total -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">Overall Total</h3>
                                <div class="overflow-hidden">
                                    <div class="bg-white rounded-lg border border-gray-200">
                                        <div class="px-6 py-4">
                                            <span class="text-2xl font-bold text-gray-900">
                                                Php {{ number_format($overallTotal, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section>
                            @php
                                $headers = [
                                    'myid' => 'ID',
                                    'payment_method' => 'Payment Method',
                                    'payment_amount' => 'Amount',
                                    'payment_date' => 'Payment Date',
                                    'action' => 'Action'
                                ];
                                $dropdownActions = [];
                                $dltAllbtn = ["Lock Selected", "transaction.bulk-lock"];
                                $dltAllbtn = [];
                                $tableActions = ['view' => 'transaction.edit', 'delete-item' => 'transaction.destroy'];
                                $addButton = [];
                                $filterRoute = route('transaction.index');
                                $customMessage = [
                                    'success' => '',
                                    'delete' => 'This User will be permanently deleted if you proceed.',
                                ];
                            @endphp
                            <x-table-transaction :headers="$headers" :data="$data" title="" :dropdown="$dropdownActions" :actions="$tableActions"
                                tablename="transaction" :filterRoute="$filterRoute" :tableCheckedbox="$tableCheckedbox" :addbtn="$addButton" :filters="$areaFilter" :searchField="true" :dltAllbtn="$dltAllbtn"
                                itemName="transaction" :message="$customMessage" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    // Event listener for delete confirmation using Swal
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This Transaction will be permanently deleted if you proceed.',
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
        axios.delete(`/transaction/${id}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                // Show success alert
                Swal.fire('Deleted!', 'The Transaction has been deleted.', 'success');
                // Reload or update the page
                location.reload();
            })
            .catch(error => {
                // Handle errors (if any)
                Swal.fire('Error!', 'There was an issue deleting the Transaction', 'error');
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
