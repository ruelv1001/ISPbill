<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/heroicons@1.0.6/dist/outline/index.min.js"></script>

<div class="flex space-x-4">
    <!-- View Button with Icon -->
    <a href="{{ route('paybill.create', $row->id) }}"
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
    @if($row->detail && $row->detail->is_lock !== 'lock')
        <form action="" method="POST" id="dynamic-delete-form" data-locked="{{ $row->detail->is_lock }}">
            @csrf
            @method('DELETE')
            <button type="button" class="text-red-500 hover:text-red-700 flex items-center space-x-2"
                onclick="confirmDelete('{{ route('transaction.destroy', $row->id) }}')" id="delete-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                    <path
                        d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17"
                        stroke="#f41010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span></span>
            </button>
        </form>
    @endif

</div>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Are you sure?',
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
