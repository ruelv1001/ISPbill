<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
    
            <th>
                <input type="checkbox" wire:click="toggleSelectAll($event.target.checked)" class="form-checkbox h-5 w-5">
            </th>
            <th>Name</th>
            <th>Router</th>
            <th>Package</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
               
                <td>
                    <input
                        type="checkbox"
                        wire:model="selectedUsers"
                        value="{{ $user->id }}"
                        class="form-checkbox h-5 w-5"
                    >
                </td>

                <!-- Other Columns -->
                <td>{{ $user->name }}</td>
                <td>{{ $user->router_name }}</td>
                <td>{{ $user->package_name }}</td>
                <!-- Add other columns here as necessary -->
            </tr>
        @endforeach
    </tbody>
</table>