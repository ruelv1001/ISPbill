<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/heroicons@1.0.6/dist/outline/index.min.js"></script>

<div class="flex space-x-4">
    <!-- View Button with Icon -->
    <form action="{{ route('archive.archive', $row->id) }}" method="POST"
        onsubmit="return confirm('Are you sure you want to Restore this user?');">
        @csrf
        <button type="submit" class="text-blue-500 hover:text-blue-700 flex items-center space-x-2">
            <i class="fas fa-undo fa-lg"></i>
            <span></span>
        </button>
    </form>



    <a href="{{ route('archieve.edit', $row) }}" class="text-blue-500 hover:text-blue-700 flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor"
            aria-hidden="true">
            <path fill-rule="evenodd"
                d="M10 3C5.58 3 2.32 5.49 1.2 8.41a1 1 0 0 0 0 .79C2.32 14.51 5.58 17 10 17c4.42 0 7.68-2.49 8.8-5.41a1 1 0 0 0 0-.79C17.68 5.49 14.42 3 10 3zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"
                clip-rule="evenodd" />
        </svg>
        <span></span>
    </a>


    <!-- Delete Form with Icon -->



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