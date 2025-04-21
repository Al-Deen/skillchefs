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
        <div class="col-12">
            <div class="course-carousel-active swiper arrow-style">
                <div class="swiper-wrapper">
                    <!-- single slide  -->
                    @foreach ($data['courses'] as $course)
                        <div class="swiper-slide">
                            @include('frontend.partials.course.course_widget', [
                                'course' => $course,
                            ])
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next swiper-btn">
                    <i class="ri-arrow-right-line"></i>
                </div>
                <div class="swiper-button-prev swiper-btn">
                    <i class="ri-arrow-left-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>
