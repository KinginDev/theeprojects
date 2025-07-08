<ul class="navbar-nav ms-auto">
    @foreach ($menu->items as $item)
        <li class="nav-item {{ count($item->children) > 0 ? 'dropdown' : '' }}">
            @if (count($item->children) > 0)
                <a class="nav-link dropdown-toggle" href="{{ $item->url ?? '#' }}" id="navbarDropdown{{ $item->id }}"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false" target="{{ $item->target ?? '_self' }}">
                    {{ $item->title }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $item->id }}">
                    @foreach ($item->children as $child)
                        <li>
                            <a class="dropdown-item"
                                href="{{ $child->url ?? route('page.show', $child->page->slug ?? '') }}"
                                target="{{ $child->target ?? '_self' }}">
                                {{ $child->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <a class="nav-link"
                    href="{{ $item->url ?? ($item->page ? route('page.show', $item->page->slug) : '#') }}"
                    target="{{ $item->target ?? '_self' }}">
                    {{ $item->title }}
                </a>
            @endif
        </li>
    @endforeach
</ul>
