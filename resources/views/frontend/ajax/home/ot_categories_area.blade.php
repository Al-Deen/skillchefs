@if (!empty($data['popularCategories']))
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="categories-active swiper arrow-style">

                    <div class="swiper-wrapper mb-20">
                        @foreach ($data['popularCategories'] as $key => $popularCategory)
                            <!-- single slide  -->
                            <div class="swiper-slide text-center white-bg h-calc">

                                <a href="{{ route('frontend.category', ['q' => $popularCategory->slug]) }}" class="single-categories tilt-effect h-calc text-center">
                                    <div class="icon">
                                        <img class="img-cover" src="{{ showImage(@$popularCategory->iconImage->paths['35x35'], 'backend/uploads/default-images/course-category/category-'.$key + 1 .'.png') }}" alt="{{ @$category->title }}">
                                    </div>
                                    <div class="cat-caption">
                                        <h4 class="title  line-clamp-2">{{ @$popularCategory->title }}</h4>
                                    </div>
                                </a>

                            </div>
                            <!-- single slide  -->
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

@endif
