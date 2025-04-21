@forelse ($data['instructors'] as $key => $instructor)
    <!-- Single Instructor -->
    <div class="single-instructor mb-24">
        <div class="listCap">
            <div class="instructor-img">
                <a href="{{ route('frontend.instructor.details', [$instructor->user->name, $instructor->user_id]) }}"><img
                        src="{{ showImage(@$instructor->user->image->original) }}" class="img-cover" alt="images"></a>
            </div>
            <div class="recentCaption">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <h5><a href="{{ route('frontend.instructor.details', [$instructor->user->name, $instructor->user_id]) }}"
                            class="title colorEffect  font-600 mb-0">{{ @$instructor->user->name }}</a></h5>
                    <a href="{{ route('frontend.instructor.details', [$instructor->user->name, $instructor->user_id]) }}"
                        class="btn-primary-outline mb-10">{{ ___('frontend.See Details') }} <i
                            class="ri-arrow-right-s-line"></i></a>
                </div>
                <p class="rating mb-10">
                    <i class="ri-star-fill"></i>
                    <span class="ratting-count font-500"> ({{ @$instructor->ratings() ?? 0 }})</span>
                    <span class="total-ratting font-600">
                        ({{ $instructor->totalReviews() > 1 ? $instructor->totalReviews() . ' ' . ___('frontend.Ratings') : $instructor->totalReviews() . ' ' . ___('frontend.Rating') }})
                    </span>
                </p>
                <div class="d-flex flex-wrap mb-10">
                    <div class="sale-status">
                        <i class="ri-parent-line"></i>
                        <span class="count font-500">{{ @$instructor->courses->sum('total_sales') }}</span>
                        <span class="pera font-500">
                            @if (@$instructor->courses->sum('total_sales') > 1)
                                {{ ___('frontend.Sales') }}
                            @else
                                {{ ___('frontend.Sales') }}
                            @endif
                        </span>
                    </div>
                </div>
                <p class="pera text-16 mb-10">{{ Str::limit( @$instructor->about_me,100) }}</p>
                @if (@$instructor->skills)
                    <div class="tag-area2 d-flex align-items-center flex-wrap">
                        <span
                            class="tag-cout text-title text-16 font-600 mr-10 mb-16">{{ ___('frontend.Expertise') }}</span>
                        <ul class="listing">
                            @foreach (@$instructor->skills as $key => $skill)
                                <li class="single-list">{{ @$skill['value'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End-of Pagination -->
@empty
    <div class="col-lg-12">
        <div class="alert alert-warning">
            {{ ___('frontend.No instructor found') }}
        </div>
    </div>
@endforelse
<?= $data['instructors']->links('frontend.partials.pagination', ['event' => 'coursePagination']) ?>
