@php
$searchField = filter_var($searchField, FILTER_VALIDATE_BOOLEAN);
@endphp
<div id="{{ $tablename }}-table" class="table-container relative shadow-md sm:rounded-lg">
    <div class="flex items-center justify-between table-title rounded-t-xl">
        <h3>{{ $title }}</h3>
        @if (!empty($addbtn))
            <a href="{{ route($addbtn[1]) }}" class="btn btn-success">
                <x-image src="/images/plus.svg" alt="Placeholder Image" class="" width="20" height="20" />
                {{ $addbtn[0] }}
            </a>
        @endif
    </div>
    @if ((empty((array) $filters) && count($filters) > 0) || $searchField == true)
        <div class="flex items-center justify-between table-filters-search px-4 py-3">
            <div class="table-filters-container">
                @if (count($filters) > 0)
                    <form action="{{ isset($filterRoute) ? $filterRoute : route('users.index') }}" method="GET"
                        id="filter-form-{{ $tablename }}" class="filter-form">
                        <input type="hidden" name="tab-active" value="{{ $tablename }}">
                        <div class="table-filters relative flex items-center space-x-2 ">
                            <x-image src="/images/filter.svg" alt="Placeholder Image" class="filter-svg" width="18"
                                height="18" />
                            <div class="table-filter-items relative flex items-center space-x-1">
                                @foreach ($filters as $filter => $values)
                                    @if ($filter == 'date' || str_contains($filter, 'date'))
                                        <input type="text" placeholder="{{ ucfirst(preg_replace('/[^A-Za-z0-9 ]/', ' ', $filter)) }}"
                                            placeholder="{{ ucfirst(preg_replace('/[^A-Za-z0-9 ]/', ' ', $filter)) }}"
                                            name="{{ $filter }}" value="{{ request($filter) }}"
                                            class="has-datepicker date-filter filter-item">
                                    @else
                                        <select class="p-2 table-filter-item filter-item select2-filter" name="{{ $filter }}"
                                            data-value="{{ $tablename == request('tab-active') ? request($filter) : '' }}"
                                            data-placeholder="{{ ucfirst($filter) }}">
                                            <option disabled selected="selected">{{ ucfirst($filter) }}</option>
                                            @foreach ($values as $value => $item)
                                                <option value="{{ $value }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                @endforeach
                                <button type="submit" class="table-filter-btn table-filter-apply">Apply</button>
                                <a href="/users" class="table-filter-btn table-filter-clear">Clear</a>

                            </div>
                        </div>

                    </form>
                @endif
            </div>
            <div class="table-search-container">
                @if ($searchField == true)
                    <form action="{{ isset($filterRoute) ? $filterRoute : route('users.index') }}" method="GET">
                        <div class="relative flex bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                            <input type="hidden" name="tab-active" value="{{ $tablename }}">
                            <input type="search"
                                class="relative m-0 block flex-auto  bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-surface outline-none"
                                placeholder="Search" aria-label="Search" id="searchBnt" name="search"
                                value="{{ request('search') }}" />
                            <button class="relative" type="submit">
                                <span class="flex items-center px-3 py-[0.25rem]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
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
        <div class="flex items-center justify-between table-options hidden"> <!-- Changed 'hide' to 'hidden' -->
            <p><span class="count">0</span> items selected</p>
            <div class="flex items-center options">
                <input type="hidden" name="selected_ids" class="selected-ids">
                @if (!empty($dropdown))
                    <select class="w-fit select-option">
                        <option value="0" disabled selected>Select Action</option>
                        @foreach ($dropdown as $index => $values)
                            <option value="{{ $index }}">{{ $values }}</option>
                        @endforeach
                    </select>
                @endif

                @if (!empty($dltAllbtn))
                    <form id="delete-{{ strtolower($tablename) }}tbl-ids" action="{{ route($dltAllbtn[1]) }}" method="POST"
                        class="hidden">
                        @csrf
                    </form>
                    <button type="button"
                        onclick="openDeleteAllModal('{{ isset($itemName) && $itemName != '' ? $itemName : 'Items' }}','delete-{{ strtolower($tablename) }}tbl-ids','{{ isset($message) && isset($message['delete']) ? $message['delete'] : '' }}')"
                        class="btn btn-delete">
                    <i class="fas fa-lock text-red-500"></i>
                        {{ $dltAllbtn[0] }}
                    </button>
                @endif

                <span class="separator">|</span>
                <button class="btn btn-outline clear-checkbox">Cancel</button>
            </div>
        </div>
    @endif
    <div class="overflow-x-auto table-content-container">
        <table class="table-content w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs">
                <tr class="border-b border-t">
                    @foreach ($headers as $index => $header)
                        <th scope="col" class="px-6 py-3 {{ $index }} {{ $index == 'id' ? 'flex items-center ' : '' }}">
                            @if ($index == 'id' && $tableCheckedbox)
                                <input id="checkbox-all-{{ $tablename }}" type="checkbox"
                                    class="checkbox-all-search checkbox-input">
                                <label for="checkbox-all-{{ $tablename }}" class="checkbox-label">checkbox</label>
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
                                                            <tr data-trid="{{ $tablename }}-{{ $row['id'] }}" class="border-b">
                                                                @foreach ($headers as $index => $header)
                                                                                                    <td
                                                                                                        class="px-6 py-3 {{ $index }} {{ $index == 'address' ? 'overflow-hidden truncate ' : '' }} {{ $index == 'id' ? 'flex items-center ' : '' }}">
                                                                                                        @if ($index == 'id' && $tableCheckedbox)
                                                                                                            <input id="checkbox-{{ $tablename }}-{{ $row['id'] }}" type="checkbox" class="checkbox-input" />
                                                                                                            <label for="checkbox-{{ $tablename }}-{{ $row['id'] }}" class="checkbox-label">checkbox</label>
                                                                                                            {{ $row[$index] }}
                                                                                                        @else
                                                                                                                                                            @php
                                                                                                                        $viewOnly =
                                                                                                                            isset($row['registration_closed']) && $row['registration_closed']
                                                                                                                            ? $row['registration_closed']
                                                                                                                            : false;

                                                                                                                                                            @endphp

                                                                                                                                                                @if ($index == 'status' || $index == 'classification')
                                                                                                                                                                    <span class="{{ strtolower($row[$index]) }}">
                                                                                                                                                                @endif

                                                                                                                                                                    @if ($index == 'active_due_date')
                                                                                                                                                                                                                                @php
                                                                                                                                                                                                                                    $dueDate = \Carbon\Carbon::parse($row['active_due_date']);
                                                                                                                                                                                                                                    $currentDate = \Carbon\Carbon::now();
                                                                                                                                                                                                                                    $colorClass = $dueDate->isPast() ? 'text-red-500' : 'text-green-500';
                                                                                                                                                                                                                                @endphp
                                                                                                                                                                                                                                <span class="{{ $colorClass }}">
                                                                                                                                                                    @endif

                                                                                                                                                                @if ($index == 'action')
                                                                                                                                                                    <div class="action-container">
                                                                                                                                                                        @foreach ($actions as $action => $route)
                                                                                                                                                                            @if ($action == 'edit' && !$viewOnly)
                                                                                                                                                                                <a href="{{ route($route, $row['id']) }}"
                                                                                                                                                                                    class="{{ $action }} action-icon action-icon-{{ $action }} transition-transform duration-200">
                                                                                                                                                                                    <x-image src="/images/edit.svg" alt="edit svg"
                                                                                                                                                                                        class="transition duration-100 group-hover:fill-green-100" width="20"
                                                                                                                                                                                        height="20" />
                                                                                                                                                                                </a>
                                                                                                                                                                            @elseif ($action == 'edit-schedule')
                                                                                                                                                                                <a href="{{ route($route, $row['id']) }}"
                                                                                                                                                                                    class="{{ $action }} action-icon action-icon-{{ $action }} transition-transform duration-200">
                                                                                                                                                                                    <x-image src="/images/view.svg" alt="edit svg" class="" width="20" height="20" />
                                                                                                                                                                                </a>
                                                                                                                                                                            @elseif ($action == 'delete')
                                                                                                                                                                                <form
                                                                                                                                                                                    id="delete-{{ strtolower($tablename) }}tbl-{{ isset($itemName) && $itemName != '' ? strtolower($itemName) : 'item' }}-{{ $row['id'] }}"
                                                                                                                                                                                    action="{{ route($route, $row['id']) }}" method="POST" style="display: none;">
                                                                                                                                                                                    @csrf
                                                                                                                                                                                    @method('DELETE')
                                                                                                                                                                                </form>
                                                                                                                                                                                <button type="button"
                                                                                                                                                                                    onclick="openDeleteModal('{{ isset($itemName) && $itemName != '' ? $itemName : 'Item' }}', 'delete-{{ strtolower($tablename) }}tbl-{{ isset($itemName) && $itemName != '' ? strtolower($itemName) : 'item' }}-{{ $row['id'] }}','{{ isset($message) && isset($message['delete']) ? $message['delete'] : '' }}')"
                                                                                                                                                                                    class="{{ $action }} action-icon action-icon-{{ $action }} transition-transform duration-200 ">
                                                                                                                                                                                    <x-image src="/images/delete-big.svg" alt="delete svg"
                                                                                                                                                                                        class="transition duration-200 group-hover:fill-green-500" width="20"
                                                                                                                                                                                        height="20" />
                                                                                                                                                                                </button>
                                                                                                                                                                            @elseif ($action == 'view')
                                                                                                                                                                                <a href="{{ route($route, $row['id']) }}"
                                                                                                                                                                                    class="{{ $action }} action-icon action-icon-{{ $action }}">
                                                                                                                                                                                    <x-image src="/images/view.svg" alt="edit svg" class="" width="20" height="20" />
                                                                                                                                                                                </a>
                                                                                                                                                                            @elseif ($action == 'view-participating-schools')
                                                                                                                                                                                <a href="{{ route('convention.participating-schools', $row['id']) }}"
                                                                                                                                                                                    class="{{ $action }} action-icon action-icon-{{ $action }}">
                                                                                                                                                                                    <x-image src="/images/view.svg" alt="edit svg" class="" width="20" height="20" />
                                                                                                                                                                                </a>

                                                                                                                                                                            @elseif ($action == 'pay')

                                                                                                                                                                                <button type="button" class="{{ $action }} action-icon action-icon-{{ $action }}"
                                                                                                                                                                                    onclick="openPaymentModal({{ $row['id'] }});">
                                                                                                                                                                                    <x-image src="/images/pay.svg" alt="pay svg" class="" width="20" height="20" />
                                                                                                                                                                                </button>
                                                                                                                                                                            @elseif ($action == 'delete-item')

                                                                                                                                                                                <button type="button"
                                                                                                                                                                                    class="{{ $action }} action-icon action-icon-{{ $action }} opacity-100 hover:opacity-100 visible hover:visible"
                                                                                                                                                                                    onclick="confirmDelete({{ $row['id'] }});">
                                                                                                                                                                                    <x-image src="/images/trash.svg" alt="pay svg" class="" width="20" height="20" />
                                                                                                                                                                                </button>
                                                                                                                                                                            @endif




                                                                                                                                                                        @endforeach
                                                                                                                                                                        @if ($row['is_lock'] == 'lock')
                                                                                                                                                                            <span class="lock-icon mt-1">
                                                                                                                                                                                <i class="fas fa-lock text-red-500"></i>
                                                                                                                                                                            </span>
                                                                                                                                                                        @elseif ($row['is_lock'] == 'unlock')
                                                                                                                                                                            <span class="unlock-icon mt-1">
                                                                                                                                                                                <i class="fas fa-unlock"></i>
                                                                                                                                                                            </span>
                                                                                                                                                                        @endif
                                                                                                                                                                    </div>
                                                                                                                                                                @else
                                                                                                                                                                    @if (isset($isDropdown) and in_array($index, $isDropdown))
                                                                                                                                                                        <select id="{{ $index }}" data-id="{{ $row['id'] }}" name="{{ $index }}" required
                                                                                                                                                                            class="{{ $index . '_dropdown' }} block w-full rounded-lg border-0 px-[0.875rem] py-[0.625rem] text-base text-[#101828] shadow-sm ring-1 ring-inset ring-[#D0D5DD] placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                                                                                                                                                                            @foreach ($isDropdownOptions[$index] as $option)
                                                                                                                                                                                <option value="{{ $option }}" @if($option == $row[$index]) selected @endif>{{ $option }}
                                                                                                                                                                                </option>
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
                    <tr class="border-b">
                        <td class="px-6 py-3 text-center" colspan="{{ count($headers) }}">No Results Found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        {{ $data->appends(array_merge(request()->only('search', 'tab-active'), ['tab-active' => $tablename]))->links('components.pagination', ['tabActive' => $tablename, 'filterRoute' => $filterRoute]) }}
    </div>
</div>
@push('scripts')
    <script>
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


        document.addEventListener('DOMContentLoaded', function () {
            const tableContainer = document.getElementById('{{ $tablename }}-table');
            if (!tableContainer) return;

            const checkboxAll = tableContainer.querySelector('.checkbox-all-search');
            const checkboxes = tableContainer.querySelectorAll('tbody .checkbox-input');
            const tableOptions = tableContainer.querySelector('.table-options');
            const countSpan = tableContainer.querySelector('.count');
            const clearCheckbox = tableContainer.querySelector('.clear-checkbox');
            const selectedIdsInput = tableContainer.querySelector('.selected-ids');

            function updateSelectedCount() {
                const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
                const count = checkedBoxes.length;

                if (countSpan) countSpan.textContent = count;
                if (tableOptions) {
                    if (count > 0) {
                        tableOptions.classList.remove('hidden');
                    } else {
                        tableOptions.classList.add('hidden');
                    }
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

            // Handle clear button
            if (clearCheckbox) {
                clearCheckbox.addEventListener('click', function () {
                    checkboxes.forEach(cb => cb.checked = false);
                    if (checkboxAll) checkboxAll.checked = false;
                    updateSelectedCount();
                });
            }
        });
    </script>
@endpush
