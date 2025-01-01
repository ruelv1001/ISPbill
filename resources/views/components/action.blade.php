<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/heroicons@1.0.6/dist/outline/index.min.js"></script>

<div class="flex space-x-4">
    <!-- Edit Button with Icon -->
    <a href="javascript:void(0)" class="text-blue-500 hover:text-blue-700 flex items-center space-x-2"
        onclick="navigateToEdit('{{ route('transaction.edit', $row->id) }}')">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"
            aria-hidden="true">
            <path fill-rule="evenodd"
                d="M10 4.5a5.5 5.5 0 10-.001 11.001A5.5 5.5 0 0010 4.5zm0 9a3.5 3.5 0 110-7 3.5 3.5 0 010 7zm6.5-4a6.978 6.978 0 01-1.5 4.5c-1.09 1.31-2.51 2.18-4.08 2.71A6.97 6.97 0 0110 15c-1.46 0-2.82-.49-3.92-1.29-1.57-.53-2.98-1.4-4.08-2.71a6.978 6.978 0 01-1.5-4.5c0-.9.26-1.78.73-2.53 1.36-1.82 3.42-2.97 5.77-2.97 2.35 0 4.41 1.15 5.77 2.97.47.75.73 1.63.73 2.53z"
                clip-rule="evenodd" />
        </svg>
        <span>Edit</span>
    </a>

    <!-- Delete Form with Icon -->
    <form action="" method="POST" id="dynamic-delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="text-red-500 hover:text-red-700 flex items-center space-x-2"
            onclick="confirmDelete('{{ route('transaction.destroy', $row->id) }}')">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Delete</span>
        </button>
    </form>
</div>

<script>
    function navigateToEdit(editUrl) {
        window.location.href = editUrl;
    }

    function confirmDelete(deleteUrl) {
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
                const form = document.getElementById('dynamic-delete-form');
                form.action = deleteUrl;
                form.submit();
            }
        });
    }
</script>
