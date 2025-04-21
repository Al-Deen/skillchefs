<div class="container">
    <div class="row">
        {{-- Section Title --}}
        <div class=" col-xl-12">
            <div class="d-flex align-items-start flex-wrap gap-10 mb-45">
                <div class="section-tittle flex-fill">
                    <h3 class="text-capitalize font-600">{{ $data['title'] }}</h3>
                </div>
                <a class="btn-primary-fill bisg-btn" href="{{ $data['url'] }}">
                    {{ ___('frontend.See All') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row g-24">

        @foreach ($data['events'] as $key => $event)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 view-wrapper">
                @include('event::frontend.partials.widget', [
                    'event' => $event,
                ])
            </div>
        @endforeach

    </div>
</div>
