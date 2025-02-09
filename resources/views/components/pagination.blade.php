<nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
    <div>
        <form action="{{ isset($filterRoute) ? $filterRoute : route('users.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px;">
            @foreach (request()->all() as $index => $value)
                @if(!empty($value) && $index !== 'per_page')
                    <input type="hidden" name="{{ $index }}" value="{{ $value }}">
                @endif
            @endforeach
            <label for="eventsPerPageSelector">Entries per page:</label>
            <select id="eventsPerPageSelector" name="per_page" required onchange="this.form.submit()"
                style="padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="10" {{ request()->get('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request()->get('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request()->get('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
            </select>
        </form>
    </div>

    <div style="display: flex; gap: 5px; align-items: center;">
        @if ($paginator->onFirstPage())
            <span style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #eaeaea; color: #888; cursor: not-allowed;">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #333;">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f1f1f1;">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 5px 10px; border: 1px solid #007bff; border-radius: 5px; background-color: #007bff; color: white;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #333;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #333;">&raquo;</a>
        @else
            <span style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #eaeaea; color: #888; cursor: not-allowed;">&raquo;</span>
        @endif
    </div>
</nav>
