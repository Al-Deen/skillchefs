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
                                         <a href="{{ route('frontend.bookDetails', $book->slug) }}">
                                             <h4 class="title colorEffect line-clamp-2 text-15 font-500">
                                                 {{ @$book->title }}
                                             </h4>
                                         </a>
                                         @if (@$book->user->role_id != 5)
                                             <div class="course-widget-author d-flex align-items-center">
                                                 <div class="course-widget-author-img">
                                                     <img src="{{ showImage(@$book->user->image->original) }}" class="img-cover" alt="img">
                                                 </div>
                                                 <div class="">
                                                     <a href="javascript:void(0);">
                                                         <h4 class="text-14 font-500 text-primary-hover  mb-0">{{ @$book->user->name }}</h4>
                                                     </a>
                                                     <p class="text-gray text-12 font-400  line-clamp-1">{{ ___('common.Admin') }}</p>
                                                 </div>
                                             </div>
                                         @else
                                             <div class="course-widget-author d-flex align-items-center">
                                                 <div class="course-widget-author-img">
                                                     <img src="{{ showImage(@$book->user->image->original) }}" class="img-cover" alt="img">
                                                 </div>
                                                 <div class="">
                                                     <a href="{{ route('frontend.instructor.details', [$book->user->name, $book->user->id]) }}">
                                                         <h4 class="text-14 font-500 text-primary-hover  mb-0">{{ @$book->user->name }}</h4>
                                                     </a>
                                                     <p class="text-gray text-12 font-400  line-clamp-1">{{ @$book->user->instructor->designation }}
                                                     </p>
                                                 </div>
                                             </div>
                                         @endif
                                         <div class="widget-footer">
                                             <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                 <div class="pricing mt-2">
                                                     @if ($book->is_free == 1)
                                                         <h4>{{ ___('frontend.Free') }}</h4>
                                                     @else
                                                         <h4 class="prev-prise">
                                                             <span>{{ showPrice($book->price) }}</span>
                                                         </h4>
                                                     @endif
                                                 </div>
                                                 <a href="{{ route('frontend.bookDetails', $book->slug) }}" class="btn-primary-outline mb-10"><i
                                                         class="ri-shopping-cart-line"></i> {{ ___('frontend.Enroll') }} </a>
                                             </div>
                                         </div>
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
