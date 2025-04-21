<div class="course-widget radius-12 h-calc ">
    <div class="course-widget-img position-relative overflow-hidden">
        <a href="{{ route('event.home.details', $event->slug) }}">
            <img src="{{ showImage(@$event->image->original, 'backend/uploads/default-images/event/event-'.$event->category->id .'.jpg') }}" class="img-cover" alt="img">
        </a>
        <a class="course-badge position-absolute text-12 font-500 radius-4 d-inline-flex "
            href="javascript:void(0)">{{ @$event->category->title }}</a>
    </div>
    <div class="widget-mid w-100 ">
        <div class="course-widget-info mb-18">
            <div class="course-widget-info-title mb-15">
                <a href="{{ route('event.home.details', $event->slug) }}">
                    <h4 class="title colorEffect line-clamp-2 text-16 font-500">
                        {{ Str::limit(@$event->title, @$limit ?? 29) }}</h4>
                </a>
            </div>
            <div class="course-widget-info_rating">
                <div class="d-flex align-items-start gap-10 mb-0 flex-column">

                    <div class="d-flex align-items-center gap-5">
                        <i class="ri-calendar-2-line"></i>
                        <h5 class="text-12 font-400 text-gray">
                            {{ date('D, d M Y', strtotime($event->start)) }} -
                            {{ date('D, d M Y', strtotime($event->end)) }}
                        </h5>

                    </div>

                    <div class="d-flex align-items-center gap-5">
                        <i class="ri-map-pin-line"></i>
                        <h5 class="text-12 font-400 text-gray">
                            <span>{{ @$event->address }}</span>
                        </h5>
                    </div>
                    <div class="d-flex align-items-center gap-5">
                        <i class="ri-user-line"></i>
                        <h5 class="text-12 font-400 text-gray">
                            <span>
                                {{ @$event->user->name }}
                            </span>
                        </h5>
                    </div>

                </div>
            </div>
        </div>

        <div class="widget-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="pricing mb-10">
                    @if (@$event->is_paid || $event->price > 0)
                        <h4 class="prev-prise">
                            <span class="text-12 font-700 text-gray">{{ showPrice(@$event->price) }}</span>
                        </h4>
                    @else
                        {{ ___('frontend.Free') }}
                    @endif
                </div>
                @if(@$event->register_student->status === 'paid')
                <a href="{{ route('event.home.details', $event->slug) }}" class="btn-primary-outline mb-10">
                    {{ ___('frontend.Booked') }}
                </a>
                @else
                <a href="{{ route('event.home.details', $event->slug) }}" class="btn-primary-outline mb-10">
                    {{ ___('frontend.Book') }}
                </a>
                @endif
            </div>
        </div>
    </div>

</div>
