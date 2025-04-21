<div class="theme-according mb-24" id="accordion1">
    @foreach ($sections as $key => $section)
        <div class="card">
            <div class="card-header pink_bg" id="four4">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour{{ $key }}" aria-expanded="false" aria-controls="four4">
                        <span class="course-curriculum-title">{{ @$section->title }}</span>
                        <span class="course-curriculum-lesson">
                            {{ $section->allLesson->count() }}
                            {{ ___('frontend.Lesson') }} -
                            {{ minutes_to_hours($section->lessons->sum('duration')) }}
                        </span>
                    </button>
                </h5>
            </div>
            <div class="collapse" id="collapseFour{{ $key }}" data-parent="#accordion1">
                <div class="card-body">
                    <ul class="course-video-lists">
                        @foreach ($section->allLesson as $key => $lesson)
                            <li>
                                @if ($lesson->is_quiz)
                                    <i class="ri-question-line"></i>
                                @else
                                    @if (in_array(@$lesson->lesson_type, ['Youtube', 'Vimeo', 'GoogleDrive', 'VideoFile']))
                                        <i class="ri-play-circle-line"></i>
                                    @elseif(@$lesson->lesson_type == 'Text')
                                        <i class="ri-text"></i>
                                    @elseif(@$lesson->lesson_type == 'ImageFile')
                                        <i class="ri-image-fill"></i>
                                    @elseif(@$lesson->lesson_type == 'DocumentFile' && @$lesson->attachment_type == 1)
                                        <i class="ri-file-pdf-line"></i>
                                    @elseif(@$lesson->lesson_type == 'DocumentFile' && @$lesson->attachment_type == 2)
                                        <i class="ri-file-text-fill"></i>
                                    @endif
                                @endif
                                {{ $lesson->title }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach


</div>
