@forelse (@$data['enroll']->course->reviews()->orderBy('id',  'desc')->get() as $review)
    <div class="comment_list_single">
        <div class="comment_list_thumb">
            <img src="{{ showImage(@$review->user->image) }}" class="img-cover" alt="img">
        </div>
        <div class="comment_list_single_info">
            <div class="d-flex align-items-center gap-10 mb-10">
                <h4 class="text-18 font-600">
                    {{ @$review->user->name }}
                </h4>

            </div>
            <div class="d-flex align-items-center gap-10">

                <div class="rating-star d-flex align-items-center">
                    {{ rating_ui(@$review->rating, 20) }}
                </div>
                <span>
                    {{ showDate(@$review->created_at) }}
                </span>
            </div>
            <p>
                <?= @$review->comment ?>
            </p>
        </div>
    </div>
@empty
    <div class="text-center">
        <h4 class="text-18 font-600">
            {{ ___('student.No_Review_Found') }}
        </h4>
    </div>
@endforelse
