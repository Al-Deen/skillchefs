    <h3 class="course-details-title">{{ ___('frontend.Instructor Profile') }}</h3>
    <div class="instractor-tab-widget">
        <div class="instractor-tab-widget-card">
            <div class="instractor-tab-widget-thumb">
                <a
                    href="{{ route('frontend.instructor.details', [@$data['course']->instructor->name, @$data['course']->instructor->id]) }}">
                    <img class="img-fluid" src="{{ showImage(@$data['course']->instructor->image->original) }}"
                        alt="img">
                </a>
            </div>
            <div class="d-flex flex-column align-items-center">
                <h4 class="instractor-name text-capitalize"><a
                        href="{{ route('frontend.instructor.details', [$data['course']->user->name, $data['course']->user->id]) }}">{{ @$data['course']->instructor->name }}</a>
                </h4>
                <h5 class="instractor-designation">{{ @$data['course']->instructor->instructor->designation }}</h5>
                <div class="rating-star d-flex align-items-center">
                    @if (@$data['course']->instructor->instructor)
                        {{ rating_ui(@$data['course']->instructor->instructor->ratings() ?? 0, 16) }}
                    @else
                        {{ rating_ui(0, 16) }}
                    @endif
                </div>
            </div>
        </div>
        <div class="instructor-personal-info">
            <p class="pera text-16 mb-10">{{ Str::limit(@$data['course']->instructor->instructor->about_me, 550) }}</p>
            @if (@$data['course']->instructor->instructor->experience)
                <h5 class="personal-info-title">{{ ___('frontend.Experiences') }}</h5>
                <ul class="instractor-expriences_list">
                    @foreach (@$data['course']->instructor->instructor->experience as $key => $experience)
                        <li>
                            <div class="exprience_info">
                                <h5>{{ @$experience['title'] }}</h5>
                                <p>{{ @$experience['name'] }} <span>
                                        ({{ date('M y', strtotime(@$experience['start_date'])) }}
                                        -
                                        @if (@$experience['current'])
                                            {{ ___('student.Present') }}
                                        @else
                                            {{ date('M y', strtotime(@$experience['end_date'])) }}
                                        @endif)
                                    </span></p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
