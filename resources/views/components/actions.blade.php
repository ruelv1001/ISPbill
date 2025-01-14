<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/heroicons@1.0.6/dist/outline/index.min.js"></script>

<div class="flex space-x-4">
    <!-- View Button with Icon -->
    <a href="javascript:void(0)" onclick="openPaymentModal('{{ route('paybill.create', $row->id) }}')"
        class="text-blue-500 hover:text-blue-700 flex items-center space-x-2">
        <i class="fas fa-wallet fa-lg"></i>
        <span></span>
    </a>


    <a href="{{ route('users.edit', $row->id) }}" class="text-blue-500 hover:text-blue-700 flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor"
            aria-hidden="true">
            <path fill-rule="evenodd"
                d="M10 3C5.58 3 2.32 5.49 1.2 8.41a1 1 0 0 0 0 .79C2.32 14.51 5.58 17 10 17c4.42 0 7.68-2.49 8.8-5.41a1 1 0 0 0 0-.79C17.68 5.49 14.42 3 10 3zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"
                clip-rule="evenodd" />
        </svg>
        <span></span>
    </a>

    <!-- Delete Form with Icon -->


    <form action="{{ route('users.destroy', $row->id) }}" method="POST" id="delete-form-{{ $row->id }}">
        @csrf
        @method('DELETE')
        <button type="button" class="text-red-500 hover:text-red-700 flex items-center space-x-2"
            onclick="confirmDelete({{ $row->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Delete</span>
        </button>
    </form>
 
    <div id="payment-modal"
        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-3xl h-[600px]">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                    {{ __('Create Payment') }}
                </h2>
                <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div id="modal-content">
                <!-- Modal content will be injected here -->
            </div>
        </div>
    </div>



</div>


</div>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Are you sure to permanent deleted?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'bg-red-600 text-white border-red-700 hover:bg-red-700',
                cancelButton: 'bg-gray-400 text-white border-gray-500 hover:bg-gray-500'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>

<script>
    // Open Modal and Inject Content
    function openPaymentModal(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('payment-modal').classList.remove('hidden');
                document.getElementById('modal-content').innerHTML = html;
            })
            .catch(error => console.log(error));
    }

    // Close Modal
    function closePaymentModal() {
        document.getElementById('payment-modal').classList.add('hidden');
    }
</script>
<script>
    function toggleRefCode() {
        console.log("toggleRefCode function triggered"); // Debug message
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