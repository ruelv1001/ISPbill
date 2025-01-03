<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Create Payment') }}
                    </h2>

                    <form method="post" action="{{ route('paybill.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>

                            </div>


                            

                            
                                <div>
                                    <x-input-label for="payment_amount" :value="__(key: 'Amount Pay')" class="mt-4" />
                                    <x-text-input id="payment_amount" name="payment_amount" type="number"
                                        class="mt-1 block w-full bg-gray-100"
                                        value=" {{ $user->detail->package_price }}" aria-required="" />
                                </div>
                              
                               


                                <div class="flex items-center gap-4 mt-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    /* Moderate Select2 dropdown size */
    .select2-container .select2-selection--single {
        height: 42px !important;
        padding: 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px !important;
        font-size: 1.5rem !important;
    }

    .select2-dropdown {
        font-size: 1.5rem !important;
    }

    .select2-search__field {
        height: 36px !important;
        font-size: 1.5rem !important;
    }

    .select2-results__option {
        padding: 8px !important;
        font-size: 1.5rem !important;
    }
</style>
<script>
    $(document).ready(function () {
        // Initialize Select2 for the dropdown
        $('#user-select').select2({
            placeholder: 'Search for a user',
            allowClear: true
        });
    });
</script>

<script>
    function toggleRefCode() {
        const paymentMethod = document.getElementById('payment_method').value;
        const refCodeContainer = document.getElementById('ref_code_container');
        const refCodeInput = document.getElementById('ref_code');

        if (paymentMethod === 'Cash') {
            refCodeContainer.classList.add('hidden');
            refCodeInput.removeAttribute('required');
        } else {
            refCodeContainer.classList.remove('hidden');
            refCodeInput.setAttribute('required', 'required');
        }
    }
</script>