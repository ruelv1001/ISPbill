<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
    <div>
        <form action="{{ isset($filterRoute) ? $filterRoute : route('users.index') }}" method="GET" class="flex items-center">
            @if(count(request()->all()) >= 1)
                @foreach (request()->all() as $index => $value)
                    @if(!empty($value) && $index !== 'per_page')
                        <input type="hidden" name="{{ $index }}" value="{{ $value }}">
                    @endif
                @endforeach
            @else

                <input type="hidden" name="tab-active"
                    value="{{ !empty(request('tab-active')) ? request('tab-active') : (isset($tabActive) ? $tabActive : 'default_value') }}">

            @endif
            <select id="eventsPerPageSelector"
                class="w-20 border border-gray-300 rounded-lg p-2 mr-2 focus:outline-none focus:ring-2" name="per_page"
                required onchange="this.form.submit()">
                <option value="10" {{ request()->get('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request()->get('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request()->get('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
            </select>
            entries per page
        </form>
    </div>

    <div class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
        <div class="pagination-container">
            <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                            aria-hidden="true">
                            <x-image src="/images/arrow-left.svg" alt="Placeholder Image" class="" width="20" height="20" />
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                        aria-label="{{ __('pagination.previous') }}">
                        <x-image src="/images/arrow-left.svg" alt="Placeholder Image" class="" width="20" height="20" />
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                        aria-label="{{ __('pagination.next') }}">
                        <x-image src="/images/arrow-right.svg" alt="Placeholder Image" class="" width="20" height="20" />
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                            aria-hidden="true">
                            <x-image src="/images/arrow-right.svg" alt="Placeholder Image" class="" width="20"
                                height="20" />
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </div>
</nav>
