<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="banner-active arrow-style swiper p-0 radius-8">
                <div class="swiper-wrapper">
                    @if(!empty($data['sliders']))
                    @foreach($data['sliders'] as $key => $slider)
                    <div class="swiper-slide">
                        <div class="ot-banner-inner d-flex align-items-center banner-overlay position-relative z-0 banner-overlay ot-banner-img-1" style="background-image:url({{showImage(@$slider->iconImage->original, 'backend/uploads/default-images/hero/hero'.$key + 1 .'.jpg')}})">
                            <div class="banner-text">
                                @if(!empty($slider->title))
                                <h3 class="title line-clamp-2 font-700 text-white wow fadeInLeft" data-wow-delay="0.0s">
                                    <span class="sub-title">  {{@$slider->title}} </span> {{@$slider->sub_title}}
                                </h3>
                                @endif
                                @if(!empty($slider->description))
                                <p class="pera line-clamp-2 text-white wow fadeInLeft" data-wow-delay="0.2s">{{Str::limit(strip_tags(@$slider->description), 150) }} </p>
                                @endif
                                @if(!empty($slider->button_text))
                                  <a href="{{@$slider->button_url ?? '#'}}" class="fill-btn wow fadeInLeft" data-wow-delay="0.4s">{{@$slider->button_text}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                {{-- Arrow Style --}}
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

