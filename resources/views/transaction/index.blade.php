<x-app-layout>
    <div style="padding: 20px;">
        <div style="max-width: 1200px; margin: auto; padding: 10px;">
            <div style="background: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 5px;">
                <div style="padding: 15px; color: #1a202c;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                        <h2 style="font-weight: 600; font-size: 20px; color: #2d3748;">
                            {{ __('Transactions') }}
                        </h2>
                    </div>

                    <!-- Scrollable Content Section -->
                    <div style="overflow-y: auto; max-height: 80vh;">
                        <!-- Transaction Summary Section -->
                        <div style="margin-bottom: 20px;">
                            <h2 style="font-size: 18px; font-weight: bold; color: #2d3748;">Transaction Summary</h2>

                            <!-- Payment Method Summary -->
                            <div style="background: #f7fafc; border-radius: 5px; padding: 15px;">
                                <h3 style="font-size: 16px; font-weight: 600; color: #4a5568; margin-bottom: 10px;">Totals by Payment Method</h3>
                                <div style="overflow-x: auto;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                @foreach ($totalsByMethod as $method => $total)
                                                    <th style="padding: 10px; background: #edf2f7; text-align: left; font-size: 12px; font-weight: 500; color: #4a5568; text-transform: uppercase;">
                                                        {{ $method }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody style="background: white;">
                                            <tr>
                                                @foreach ($totalsByMethod as $total)
                                                    <td style="padding: 10px; text-align: left; font-size: 14px; color: #4a5568;">
                                                        Php {{ number_format($total, 2) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Daily Totals Summary -->
                            <div style="background: #f7fafc; border-radius: 5px; padding: 15px; margin-top: 10px;">
                                <h3 style="font-size: 16px; font-weight: 600; color: #4a5568; margin-bottom: 10px;">Totals by Day</h3>
                                <div style="overflow-x: auto;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                @foreach ($totalsPerDay as $date => $total)
                                                    <th style="padding: 10px; background: #edf2f7; text-align: left; font-size: 12px; font-weight: 500; color: #4a5568; text-transform: uppercase;">
                                                        {{ $date }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody style="background: white;">
                                            <tr>
                                                @foreach ($totalsPerDay as $total)
                                                    <td style="padding: 10px; text-align: left; font-size: 14px; color: #4a5568;">
                                                        Php {{ number_format($total, 2) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Overall Total -->
                            <div style="background: #f7fafc; border-radius: 5px; padding: 15px; margin-top: 10px;">
                                <h3 style="font-size: 16px; font-weight: 600; color: #4a5568; margin-bottom: 10px;">Overall Total</h3>
                                <div>
                                    <div style="background: white; border-radius: 5px; border: 1px solid #e2e8f0;">
                                        <div style="padding: 10px;">
                                            <span style="font-size: 18px; font-weight: bold; color: #1a202c;">
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
                                    'myid' => 'ID',      'payment_method' => 'Payment Method',
                                    'cname' => 'Name',
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
