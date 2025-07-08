<li class="list-group-item menu-item" data-id="{{ $item->id }}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="menu-item-handle">
            <i class="fas fa-grip-vertical me-2"></i>
            {{ $item->title }}

            @if ($item->page_id)
                <span class="badge bg-info">Page: {{ $item->page->title }}</span>
            @elseif($item->url)
                <span class="badge bg-secondary">URL: {{ $item->url }}</span>
            @endif
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary edit-item-btn" data-id="{{ $item->id }}"
                data-title="{{ $item->title }}" data-url="{{ $item->url }}" data-page-id="{{ $item->page_id }}"
                data-target="{{ $item->target }}">
                <i class="fas fa-edit"></i>
            </button>
            <form action="{{ route('merchant.menu-items.destroy', $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    @if (count($item->children) > 0)
        <ul class="list-group mt-2 menu-items-sortable nested">
            @foreach ($item->children as $child)
                @include('merchant.menus.item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>
