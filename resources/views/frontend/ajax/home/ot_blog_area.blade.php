@if (!empty($data['blogs']))
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-xl-12">
                <div class="d-flex align-items-start flex-wrap gap-10 mb-45">
                    <div class="section-tittle flex-fill">
                        <h3 class="text-capitalize font-600">{{ @$data['section_title'] }}</h3>
                    </div>
                    <a class="btn-primary-fill bisg-btn" href="{{ route('blogs') }}">
                        {{ ___('frontend.See All Blogs') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-24">
            @foreach ($data['blogs'] as $key => $blog)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="blog-single h-calc radius-8">
                        <div class="blog-img-cap">
                            <div class="blog-img imgEffect">
                                <a href="{{ route('blog_details', $blog->id) }}">
                                     <img src="{{ showImage(@$blog->iconImage->original, 'backend/uploads/default-images/blog/blog'.$key + 1 .'.jpg') }}"
                                    alt="img" class="img-cover">
                                </a>
                            </div>
                            <div class="blog-cap">
                                <h3><a href="{{ route('blog_details', $blog->id) }}" class="title colorEffect line-clamp-2 font-600">{{  Str::limit(@$blog->title, 20) }}</a></h3>
                                <p class="pera mb-15">{{ Str::limit(strip_tags(@$blog->description), 100) }}</p>
                                <p class="font-600">{{ $blog->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endif
