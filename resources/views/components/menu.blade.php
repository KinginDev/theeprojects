<ul class="navbar-nav">
    @foreach ($menuItems as $item)
        <li class="nav-item {{ count($item->children) > 0 ? 'dropdown' : '' }}">
            @if (count($item->children) > 0)
                <a class="nav-link dropdown-toggle" href="{{ $item->full_url }}" id="navbarDropdown{{ $item->id }}"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false" target="{{ $item->target }}">
                    {{ $item->title }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $item->id }}">
                    @foreach ($item->children as $child)
                        <li>
                            <a class="dropdown-item" href="{{ $child->full_url }}" target="{{ $child->target }}">
                                {{ $child->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <a class="nav-link" href="{{ $item->full_url }}" target="{{ $item->target }}">
                    {{ $item->title }}
                </a>
            @endif
        </li>
    @endforeach
</ul>
