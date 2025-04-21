<h3 class="course-details-title">{{ ___('frontend.Reviews') }}</h3>
<div class="review-wrapper">

    @forelse ($data['course']->reviews as $review)
        <!--Review single -->
        <div class="review-widget">
            <div class="review-widget-header gap-10">
                <div class="review-widget-header-author flex-fill">
                    <div class="review-widget-header-author-thumb">
                        <img class="img-cover" src="{{ showImage(@$review->user->image->original) }}"
                            alt="img">
                    </div>
                    <div class="flex-fill">
                        <h5 class="review-widget-header-author-name">
                            {{ @$review->user->name }}
                        </h5>
                        <div class="rating-star d-flex align-items-center">
                            {{ rating_ui(@$review->rating, 16) }}
                        </div>
                    </div>
                </div>
                <div class="review-widget-header-action d-flex align-items-center gap-8">
                    <p>{{ showDateTime(@$review->created_at) }}</p>
                </div>
            </div>
            <p class="review-widget-description">
                <?= @$review->comment ?>
            </p>
        </div>
        <!--Review single -->
    @empty
        <div class="text-left">
            <p class="text-left">{{ ___('frontend.No reviews found') }}</p>
        </div>
    @endforelse
</div>
