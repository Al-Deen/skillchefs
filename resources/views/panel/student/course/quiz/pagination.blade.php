<!-- Pagination -->
@if ($paginator->hasPages())

    <div class="d-flex align-items-center justify-content-between flex-wrap mt-40">
        @if ($paginator->onFirstPage())
            <button class="btn-primary-outline">{{ ___('student.Previous')}}</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn-primary-outline prevPaginationQuestion">{{ ___('student.Previous')}}</a>
        @endif
        <div class="d-flex gap-10">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn-primary-outline skipPaginationQuestion">{{ ___('student.Skip') }}</a>
                <a href="{{ $paginator->nextPageUrl() }}" class="btn-primary-fill paginationQuestion"> {{ ___('student.Next Questions') }}</a>
            @else
                <button class="btn-primary-fill submitQuestion">{{ ___('student.Submit') }}</button>
            @endif
        </div>
    </div>
@endif
<!-- Pagination -->
