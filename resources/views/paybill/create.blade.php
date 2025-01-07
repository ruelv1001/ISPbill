
    <div class="py-1">
    <form method="post" action="{{ route('paybill.store') }}" class="space-y-1">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <div class="hidden">
                <x-input-label for="user_id" :value="__('Customer name')" class="mt-4" />
                <x-text-input id="user_id" name="user_id" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $user->id }}" />
            </div>
            <div>
                <x-input-label for="name" :value="__('Customer name')" class="mt-4" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $user->detail->name }}" readonly />
            </div>

            <div>
                <x-input-label for="package_name" :value="__(key: 'Package name')" class="mt-4" />
                <x-text-input id="package_name" name="package_name" type="text" class="mt-1 block w-full bg-gray-100" value=" {{ $user->detail->package_name }}" readonly />
            </div>

            <div>
                <x-input-label for="package_price" :value="__(key: 'Package price')" class="mt-4" />
                <x-text-input id="package_price" name="package_price" type="text" class="mt-1 block w-full bg-gray-100" value=" {{ $user->detail->package_price }}" disabled />
            </div>
        </div>

        <div>
            <div>
                <x-input-label for="payment_amount" :value="__(key: 'Amount Pay')" class="mt-4" />
                <x-text-input id="payment_amount" name="payment_amount" type="number" class="mt-1 block w-full bg-gray-100" value=" {{ $user->detail->package_price }}" aria-required="" />
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

<