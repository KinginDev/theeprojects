<h5>Quick Links</h5>
<ul class="nav flex-column">
    @foreach ($menu->items as $item)
        <li class="nav-item">
            <a class="nav-link text-light"
                href="{{ $item->url ?? ($item->page ? route('page.show', $item->page->slug) : '#') }}"
                target="{{ $item->target ?? '_self' }}">
                {{ $item->title }}
            </a>
        </li>
    @endforeach
</ul>
