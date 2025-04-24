<section class="hero-area" @if($section?->color) style="background:{{ $section->color }}" @endif>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner-active arrow-style swiper p-0 radius-8">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)
                            <div class="swiper-slide">
                                <div class="ot-banner-inner d-flex align-items-center banner-overlay position-relative z-0 ot-banner-img-1" style="background-image:url({{ $slider['image'] }})">
                                    <div class="banner-text">
                                        @if($slider['title'])
                                            <h3 class="title line-clamp-2 font-700 text-white wow fadeInLeft" data-wow-delay="0.0s">
                                                <span class="sub-title">{{ $slider['title'] }}</span> {{ $slider['sub_title'] }}
                                            </h3>
                                        @endif
                                        @if($slider['description'])
                                            <p class="pera line-clamp-2 text-white wow fadeInLeft" data-wow-delay="0.2s">{{ Str::limit(strip_tags($slider['description']), 150) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Arrow Navigation -->
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
</section>
