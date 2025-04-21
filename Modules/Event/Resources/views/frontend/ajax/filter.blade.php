<div class="container">
    <div class="row g-24">
        @forelse ($data['events'] as $key => $event)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 view-wrapper">
                @include('event::frontend.partials.widget', [
                    'event' => $event,
                ])
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <h4 class="text-16 font-500">{{ ___('event.No Event Found') }}</h4>
                </div>

            </div>
        @endforelse

    </div>
    <?= $data['events']->links('frontend.partials.pagination-count', ['event' => 'dynamicPagination']) ?>
</div>
