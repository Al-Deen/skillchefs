     <!-- Blog Area S t a r t -->
     <section class="ot-blog-area section-padding section-bg-two" id="ot_blog_area" @if(@$section->color) style="background:{{ @$section->color }}" @endif>
         @if (!empty($bookData['books']))
             <div class="container">
                 <div class="row justify-content-center">
                     <div class=" col-xl-12">
                         <div class="d-flex align-items-start flex-wrap gap-10 mb-45">
                             <div class="section-tittle flex-fill">
                                 <h3 class="text-capitalize font-600">{{ @$bookData['section_title'] }}</h3>
                             </div>
                             <a class="btn-primary-fill bisg-btn" href="{{ route('all.books') }}">
                                 See All Books
                             </a>
                         </div>
                     </div>
                 </div>
                 <div class="row g-24">
                     @foreach ($bookData['books'] as $key => $book)
                         <div class="col-xl-3 col-lg-4 col-md-6">
                             <div class="blog-single h-calc radius-8">
                                 <div class="blog-img-cap">
                                     <div class="blog-img imgEffect">
                                         <a href="{{ route('frontend.bookDetails', $book->slug) }}">
                                             <img src="{{ asset($book->thumbnail) }}"
                                                  alt="img" class="img-cover">
                                         </a>
                                     </div>
                                     <div class="blog-cap">
                                         <h5><a href="{{ route('frontend.bookDetails', $book->slug) }}" class="title colorEffect line-clamp-2">{{ $book->title }}</a></h5>
                                         <p><strong>{{$book->instructor->name}}</strong></p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </div>


             </div>
         @endif

     </section>
     <!-- End-of Blog -->
