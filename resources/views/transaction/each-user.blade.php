<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                        </h2>
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
</x-app-layout>
