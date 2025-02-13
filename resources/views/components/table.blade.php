@php
$searchField = filter_var($searchField, FILTER_VALIDATE_BOOLEAN);
@endphp
<div id="{{ $tablename }}-table" style="position: relative; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border-radius: 0.5rem; background-color: #ffffff;">
    <div style="display: flex; align-items: center; justify-content: space-between; background-color: #ffff; padding: 1rem; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #374151;">{{ $title }}</h3>
        @if (!empty($addbtn))
        <a href="{{ route($addbtn[1]) }}" style="background-color: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 9999px; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <x-image src="/images/plus.svg" alt="Placeholder Image" width="20" height="20" />
            {{ $addbtn[0] }}
        </a>

        @endif
    </div>
    @if ((empty((array) $filters) && count($filters) > 0) || $searchField == true)
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background-color: #f9fafb;">
            <div>
                @if (count($filters) > 0)
                    <form action="{{ isset($filterRoute) ? $filterRoute : route('users.index') }}" method="GET" id="filter-form-{{ $tablename }}" style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="hidden" name="tab-active" value="{{ $tablename }}">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <x-image src="/images/filter.svg" alt="Placeholder Image" width="18" height="18" />
                            <div style="display: flex; align-items: center; gap: 0.25rem;">
                                @foreach ($filters as $filter => $values)
                                    @if ($filter == 'date' || str_contains($filter, 'date'))
                                        <input type="text" placeholder="{{ ucfirst(preg_replace('/[^A-Za-z0-9 ]/', ' ', $filter)) }}" name="{{ $filter }}" value="{{ request($filter) }}" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; background-color: #ffffff;">
                                    @else
                                        <select style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; background-color: #ffffff;" name="{{ $filter }}" data-value="{{ $tablename == request('tab-active') ? request($filter) : '' }}" data-placeholder="{{ ucfirst($filter) }}">
                                            <option disabled selected="selected">{{ ucfirst($filter) }}</option>
                                            @foreach ($values as $value => $item)
                                                <option value="{{ $value }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                @endforeach
                                <button type="submit" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; border: none; cursor: pointer;">Apply</button>
                                <a href="/users" style="background-color: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; text-decoration: none; border: none; cursor: pointer;">Clear</a>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            <div>
                @if ($searchField == true)
                    <form action="{{ isset($filterRoute) ? $filterRoute : route('users.index') }}" method="GET">
                        <div style="display: flex; align-items: center; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 0.5rem;">
                            <input type="hidden" name="tab-active" value="{{ $tablename }}">
                            <input type="search" style="flex: 1; background-color: transparent; padding: 0.5rem; border: none; outline: none;" placeholder="Search" aria-label="Search" id="searchBnt" name="search" value="{{ request('search') }}" />
                            <button type="submit" style="padding: 0.5rem; background-color: transparent; border: none; cursor: pointer;">
                                <span style="display: flex; align-items: center; padding: 0.5rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 1.25rem; height: 1.25rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
    @if ($tableCheckedbox)
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background-color: #f9fafb; display: none;">
            <p style="font-size: 0.875rem; color: #374151;"><span class="count">0</span> items selected</p>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="hidden" name="selected_ids" class="selected-ids">
                @if (!empty($dropdown))
                    <select style="width: fit-content; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; background-color: #ffffff;">
                        <option value="0" disabled selected>Select Action</option>
                        @foreach ($dropdown as $index => $values)
                            <option value="{{ $index }}">{{ $values }}</option>
                        @endforeach
                    </select>
                @endif

                @if (!empty($dltAllbtn))
                    <form id="delete-{{ strtolower($tablename) }}tbl-ids" action="{{ route($dltAllbtn[1]) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" onclick="openDeleteAllModal('{{ isset($itemName) && $itemName != '' ? $itemName : 'Items' }}','delete-{{ strtolower($tablename) }}tbl-ids','{{ isset($message) && isset($message['delete']) ? $message['delete'] : '' }}')" style="background-color: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; border: none; cursor: pointer;">
                        <i class="fas fa-lock" style="color: #ef4444;"></i>
                        {{ $dltAllbtn[0] }}
                    </button>
                @endif

                <span style="color: #d1d5db;">|</span>
                <button style="background-color: transparent; border: 1px solid #d1d5db; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">Cancel</button>
            </div>
        </div>
    @endif
    <div style="overflow-x: auto;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb; background-color: #f9fafb;">
                    @foreach ($headers as $index => $header)
                        <th scope="col" style="padding: 0.75rem 1.5rem; font-weight: 600; color: #374151; {{ $index == 'id' ? 'display: flex; align-items: center;' : '' }}">
                            @if ($index == 'id' && $tableCheckedbox)
                                <input id="checkbox-all-{{ $tablename }}" type="checkbox" style="margin-right: 0.5rem;">
                                <label for="checkbox-all-{{ $tablename }}"></label>
                                {{ $header }}
                            @else
                                {{ $header }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if (count($data) > 0)
                        @foreach ($data as $row)
                                    <tr data-trid="{{ $tablename }}-{{ $row['id'] }}" style="border-bottom: 1px solid #e5e7eb; background-color: #ffffff;">
                                        @foreach ($headers as $index => $header)
                                                            <td style="padding: 0.75rem 1.5rem; color: #374151; {{ $index == 'id' ? 'display: flex; align-items: center;' : '' }}">
                                                                @if ($index == 'id' && $tableCheckedbox)
                                                                    <input id="checkbox-{{ $tablename }}-{{ $row['id'] }}" type="checkbox" style="margin-right: 0.5rem;">
                                                                    <label for="checkbox-{{ $tablename }}-{{ $row['id'] }}"></label>
                                                                    {{ $row[$index] }}
                                                                @else
                                                                                            @php
                $viewOnly = isset($row['registration_closed']) && $row['registration_closed'] ? $row['registration_closed'] : false;
                                                                                            @endphp

                                                                                            @if ($index == 'status' || $index == 'classification')
                                                                                                <span style="color: {{ strtolower($row[$index]) == 'active' ? 'green' : 'red' }};">
                                                                                            @endif

                                                                                            @if ($index == 'active_due_date')
                                                                                                                        @php
                    $dueDate = \Carbon\Carbon::parse($row['active_due_date']);
                    $currentDate = \Carbon\Carbon::now();
                    $colorClass = $dueDate->isPast() ? 'red' : 'green';
                                                                                                                        @endphp
                                                                                                                        <span style="color: {{ $colorClass }};">
                                                                                            @endif
                                                                                            @if ($index == 'action')
                                                                                                <div style="display: flex; gap: 0.5rem;">
                                                                                                    @foreach ($actions as $action => $route)
                                                                                                        @if ($action == 'edit' && !$viewOnly)
                                                                                                            <a href="{{ route($route, $row['id']) }}" style="text-decoration: none;">
                                                                                                                <x-image src="/images/edit.svg" alt="edit svg" width="20" height="20" />
                                                                                                            </a>
                                                                                                        @elseif ($action == 'delete')
                                                                                                            <form id="delete-{{ strtolower($tablename) }}tbl-{{ isset($itemName) && $itemName != '' ? strtolower($itemName) : 'item' }}-{{ $row['id'] }}" action="{{ route($route, $row['id']) }}" method="POST" style="display: none;">
                                                                                                                @csrf
                                                                                                                @method('DELETE')
                                                                                                            </form>
                                                                                                            <button type="button" onclick="openDeleteModal('{{ isset($itemName) && $itemName != '' ? $itemName : 'Item' }}', 'delete-{{ strtolower($tablename) }}tbl-{{ isset($itemName) && $itemName != '' ? strtolower($itemName) : 'item' }}-{{ $row['id'] }}','{{ isset($message) && isset($message['delete']) ? $message['delete'] : '' }}')" style="background-color: transparent; border: none; cursor: pointer;">
                                                                                                                <x-image src="/images/delete-big.svg" alt="delete svg" width="20" height="20" />
                                                                                                            </button>
                                                                                                        @elseif ($action == 'view')
                                                                                                            <a href="{{ route($route, $row['id']) }}" style="text-decoration: none;">
                                                                                                                <x-image src="/images/view.svg" alt="edit svg" width="20" height="20" />
                                                                                                            </a>
                                                                                                        @elseif ($action == 'pay')
                                                                                                            <button type="button" onclick="openPaymentModal({{ $row['id'] }});" style="background-color: transparent; border: none; cursor: pointer;">
                                                                                                                <x-image src="/images/pay.svg" alt="pay svg" width="20" height="20" />
                                                                                                            </button>
                                                                                                        @elseif ($action == 'delete-item')
                                                                                                            <button type="button" onclick="confirmDelete({{ $row['id'] }});" style="background-color: transparent; border: none; cursor: pointer;">
                                                                                                                <x-image src="/images/trash.svg" alt="pay svg" width="20" height="20" />
                                                                                                            </button>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                    @if ($row['is_lock'] == 'lock')
                                                                                                        <span style="color: red;">
                                                                                                            <i class="fas fa-lock"></i>
                                                                                                        </span>
                                                                                                    @elseif ($row['is_lock'] == 'unlock')
                                                                                                        <span>
                                                                                                            <i class="fas fa-unlock"></i>
                                                                                                        </span>
                                                                                                    @endif
                                                                                                </div>
                                                                                            @else
                                                                                                @if (isset($isDropdown) and in_array($index, $isDropdown))
                                                                                                    <select id="{{ $index }}" data-id="{{ $row['id'] }}" name="{{ $index }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; background-color: #ffffff;">
                                                                                                        @foreach ($isDropdownOptions[$index] as $option)
                                                                                                            <option value="{{ $option }}" @if($option == $row[$index]) selected @endif>{{ $option }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                @else
                                                                                                    {{ $row[$index] }}
                                                                                                @endif
                                                                                            @endif

                                                                                            @if ($index == 'status' || $index == 'classification')
                                                                                                </span>
                                                                                            @endif
                                                                @endif
                                                            </td>
                                        @endforeach
                                    </tr>
                        @endforeach
                @else
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1.5rem; text-align: center; color: #374151;" colspan="{{ count($headers) }}">No Results Found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem; background-color: #f9fafb;">
        {{ $data->appends(array_merge(request()->only('search', 'tab-active'), ['tab-active' => $tablename]))->links('components.pagination', ['tabActive' => $tablename, 'filterRoute' => $filterRoute]) }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
            const tableContainer = document.getElementById('{{ $tablename }}-table');
            if (!tableContainer) return;

            const checkboxAll = tableContainer.querySelector(`#checkbox-all-{{ $tablename }}`);
            const checkboxes = tableContainer.querySelectorAll(`input[id^="checkbox-{{ $tablename }}-"]`);
            const tableOptions = tableContainer.querySelector('.table-options');
            const countSpan = tableContainer.querySelector('.count');
            const selectedIdsInput = tableContainer.querySelector('.selected-ids');

            function updateSelectedCount() {
                const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
                const count = checkedBoxes.length;

                if (countSpan) countSpan.textContent = count;

                // Show/hide options based on checkbox selection
                const optionsContainer = tableContainer.querySelector('div[style*="display: none"]');
                if (optionsContainer) {
                    optionsContainer.style.display = count > 0 ? 'flex' : 'none';
                }

                // Update hidden input with selected IDs
                if (selectedIdsInput) {
                    const selectedIds = checkedBoxes.map(cb => {
                        const row = cb.closest('tr');
                        return row.dataset.trid.split('-')[1];
                    });
                    selectedIdsInput.value = selectedIds.join(',');
                }

                // Update "select all" checkbox
                if (checkboxAll) {
                    checkboxAll.checked = count > 0 && count === checkboxes.length;
                }
            }

            // Handle "select all" checkbox
            if (checkboxAll) {
                checkboxAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateSelectedCount();
                });
            }

            // Handle individual checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Cancel button functionality
            const cancelButton = tableContainer.querySelector('button[style*="background-color: transparent"]');
            if (cancelButton) {
                cancelButton.addEventListener('click', function () {
                    checkboxes.forEach(cb => cb.checked = false);
                    if (checkboxAll) checkboxAll.checked = false;
                    updateSelectedCount();
                });
            }
        });

        function openDeleteAllModal(itemName, deleteFromID, message) {
            var textMessage = message != '' ? message : "Locking all of these " + itemName;
            Swal.fire({
                title: "Are you sure you want to lock all these " + itemName + "s?",
                text: textMessage,
                icon: "warning",
                showCloseButton: false,
                showCancelButton: true,
                confirmButtonText: 'Lock',
                customClass: {
                    confirmButton: 'bg-[#8C1823] text-white font-semibold text-sm py-2 px-4 rounded-lg transition-colors',
                    cancelButton: 'bg-white border border-secondary text-sm py-2 px-4 rounded-lg transition-colors'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(deleteFromID);
                    const formData = new FormData(form);

                    // Get selected IDs from the hidden input
                    const selectedIds = document.querySelector('.selected-ids').value;
                    formData.append('ids', selectedIds);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'bg-[#8C1823] text-white font-semibold text-sm py-2 px-4 rounded-lg transition-colors'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'An error occurred',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'bg-[#8C1823] text-white font-semibold text-sm py-2 px-4 rounded-lg transition-colors'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while processing your request.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'bg-[#8C1823] text-white font-semibold text-sm py-2 px-4 rounded-lg transition-colors'
                                }
                            });
                        });
                }
            });
        }
</script>
