<ul class="submenu">
    @foreach ($data['categories'] as $category)
        <li class="single-list">
            @if ($category->children->count() > 0)
                <a href="javascript:void(0)" class="single">
                    {{ @$category->title }} <i class="ri-arrow-right-s-line"></i>
                </a>
                <ul class="submenu">
                    @foreach ($category->children as $children)
                        <li class="single-list">
                            <a href="{{ route('frontend.category', ['q' => $children->slug]) }}" class="single">
                                {{ $children->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <a href="{{ route('frontend.category', ['q' => $category->slug]) }}" class="single">
                    {{ $category->title }}
                </a>
            @endif
        </li>
    @endforeach
</ul>
