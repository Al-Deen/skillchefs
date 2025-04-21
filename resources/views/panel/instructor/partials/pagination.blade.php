<!-- Pagination -->
@if ($paginator->hasPages())
    <div class="pagination mt-30">
        <ul class="pagination-list mb-10">

            @if ($paginator->onFirstPage())
                <li class="wow ladeInRight" data-wow-delay="0.0s">{{ ___('common.Prev') }}</li>
            @else
                <li><a class="page-number {{$event}}" href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ ___('common.Prev') }}</a></li>
            @endif

            @if ($paginator->hasMorePages())
                <li><a class="page-number {{$event}}" href="{{ $paginator->nextPageUrl() }}" rel="prev">{{ ___('common.Next') }}</a></li>
            @else
            <div class="btn-wrapper mt-30 mb-50 text-center">
                <button class="btn-primary-fill mt-6 mr-10 submitQuestion">{{ ___('student.Submit') }}</button>
            </div>
            @endif
        </ul>
    </div>
@endif
<!-- Pagination -->
