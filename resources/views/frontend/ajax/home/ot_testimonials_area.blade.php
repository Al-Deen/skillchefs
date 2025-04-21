<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="section-tittle text-center mb-15">
                <h3 class="text-capitalize font-600">{{ @$data['title'] }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="testimonial-active swiper arrow-style">
                <div class="swiper-wrapper">
                    @foreach ($data['testimonials'] as $testimonial)
                        <div class="swiper-slide">

                            <!-- Single Testimonial -->
                            <div class="single-testimonial h-calc mb-24 mt-20">
                                <div class="testimonial-caption imgEffect text-center radius-8">
                                    <div class="testimonial-founder">
                                        <div class="founder-img">
                                            <img src="{{ showImage(@$testimonial->image->original, 'default-1.jpeg') }}"
                                                alt="img" class="img-cover">
                                        </div>
                                    </div>
                                    <div class="testimonialCap">
                                        <p>
                                            {{ $testimonial->content }}
                                        </p>
                                    </div>

                                    <div class="text-center gap-5 mb-10">
                                        {{ rating_ui($testimonial->rating, 16) }}
                                    </div>
                                    <!-- founder -->
                                    <div class="text-center">
                                        <div class="founder-text">
                                            <span>{{ @$testimonial->name }}</span>
                                            <p>{{ @$testimonial->designation }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
