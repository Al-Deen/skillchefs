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
        @foreach ($data['courses'] as $course)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 view-wrapper">
                @include('frontend.partials.course.course_widget', [
                    'course' => $course,
                ])
            </div>
        @endforeach
    </div>
</div>
