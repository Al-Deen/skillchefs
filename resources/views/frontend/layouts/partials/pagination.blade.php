<!-- Pagination -->
<div class="pagination mt-30">
    <p class="page-total">{{ ___('frontend.Showing') }} <span> {{ $paginator->lastItem() }}
            {{ ___('student.Result') }} </span> {{ ___('student.out of') }} <span> {{ $paginator->total() }}
            {{ ___('course.Items') }}</span></p>
    @if ($paginator->hasPages())
        <ul class="pagination-list mb-10">

            @if ($paginator->onFirstPage())
                <li class="wow ladeInRight" data-wow-delay="0.0s"><a href="#" class="page-number"><i
                            class="ri-arrow-left-s-fill"></i></a></li>
            @else
                <li><a class="page-number" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i
                            class="ri-arrow-left-s-fill"></i></a></li>
            @endif



            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled page-number"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a href="#" class="page-number current">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}" class="page-number">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach



            @if ($paginator->hasMorePages())
                <li><a class="page-number" href="{{ $paginator->nextPageUrl() }}" rel="prev"><i
                            class="ri-arrow-right-s-fill"></i></a></li>
            @else
                <li class="disabled page-number"><span><i class="ri-arrow-right-s-fill"></i></span></li>
            @endif
        </ul>
    @endif
</div>
<!-- Pagination -->
