    <h3 class="course-details-title">{{ ___('frontend.Organization Profile') }}</h3>
    <div class="instractor-tab-widget align-items-start">

        <div class="instractor-tab-widget-card">
            <div class="instractor-tab-widget-thumb">
                <a href="{{ route('frontend.organization.details', [@$data['course']->instructor->name, @$data['course']->instructor->id]) }}">
                    <img class="img-fluid" src="{{ showImage(@$data['course']->instructor->image->original) }}" alt="img">
                </a>
            </div>
            <div class="d-flex flex-column align-items-center">
                <h4 class="instractor-name text-capitalize"><a
                        href="{{ route('frontend.organization.details', [$data['course']->user->name, $data['course']->user->id]) }}">{{ @$data['course']->instructor->name }}</a>
                </h4>
                <h5 class="instractor-designation">Organization</h5>
            </div>
        </div>

        <div class="instructor-personal-info">
            <h5 class="personal-info-title">{{ ___('frontend.About Us') }}</h5>
            <p class="pera text-14 mb-10">
                {{ Str::limit(@$data['course']->instructor->organization->about_me, 550) }}
            </p>

            <h5 class="personal-info-title mt-3 border-top pt-20">{{ ___('frontend.Our Expert Instructors') }}</h5>

            {{-- Instructors card --}}
            <div class="row">
                @foreach (@$data['instructors'] as $key => $experience)
                    <div class="col-xl-4">
                        <div class="instractor-tab-widget-card p-3">
                            <div class="instractor-tab-widget-thumb">
                                <a href="{{ route('frontend.instructor.details', [@$experience->user->name, @$experience->user->id]) }}">
                                    <img class="img-fluid" src="{{ showImage(@$experience->user->image->original) }}" alt="img">
                                </a>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <h4 class="instractor-name text-capitalize line-clamp-2">
                                    <a href="{{ route('frontend.instructor.details', [@$experience->user->name, @$experience->user->id]) }}">
                                        {{ @$experience->user->name }}
                                    </a>
                                </h4>
                                <h5 class="instractor-designation">{{ @$experience->user->designation->title }}</h5>
                                <div class="rating-star d-flex align-items-center">
                                    @if (@$data['course']->instructor->organization)
                                        {{ rating_ui(@$data['course']->instructor->organization->ratings() ?? 0, 16) }}
                                    @else
                                        {{ rating_ui(0, 16) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
