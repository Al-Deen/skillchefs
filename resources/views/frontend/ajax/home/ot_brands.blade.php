<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="section-tittle text-center mb-15">
                <h3 class="text-capitalize font-600">{{ @$data['section_title'] }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 ">
            <div class="brand-wrapper brand-active swiper arrow-style">
                <div class="swiper-wrapper">
                    @if (!empty($data['brands']))
                        @foreach ($data['brands'] as $brand)
                            <div class="swiper-slide mb-20 mt-24">
                                <div class="brand-box">
                                    <img class="img-cover"
                                        src="{{ showImage(@$brand->iconImage->original, 'default-1.jpeg') }}"
                                        alt="img">
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
