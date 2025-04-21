<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keywords" content="{{ setting('meta_keyword') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ setting('author') }}">
    <meta name="baseurl" content="{{ url('/') }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ setting('application_name') }} </title>

    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/bootstrap-5.3.0.min.css') }}">
    <!-- fonts & icon -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/fonts-icon.css') }}">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/plugin.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ url('frontend/assets/css/main-style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ url('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plyr/plyr.css') }}" />


    <style>
/* For webkit browsers (e.g., Chrome, Safari) */
    ::-webkit-scrollbar {
    width: 8px;
    }

    ::-webkit-scrollbar-track {
    background-color: transparent; /* Set the track background color to transparent */
    }

    ::-webkit-scrollbar-thumb {
    background-color: transparent; /* Set the thumb background color to transparent */
    }

        .light-mode,
        .dark-mode {
            @if (Setting('ot_primary'))
                --ot-primary: {{ Setting('ot_primary') }} !important;
            @endif
            @if (Setting('ot_secondary'))
                --ot-secondary: {{ Setting('ot_secondary') }} !important;
            @endif
            @if (Setting('ot_tertiary'))
                --ot-tertiary: {{ Setting('ot_tertiary') }} !important;
            @endif
            @if (Setting('ot_primary_rgb'))
                --ot-primary-rgb: {{ Setting('ot_primary_rgb') }} !important;
            @endif
            @if (Setting('ot_secondary_rgb'))
                --ot-secondary-rgb: {{ Setting('ot_secondary_rgb') }} !important;
            @endif
            @if (Setting('ot_tertiary_rgb'))
                --ot-tertiary-rgb: {{ Setting('ot_tertiary_rgb') }} !important;
            @endif
            @if (Setting('ot_primary_btn'))
                --ot-primary-btn: {{ Setting('ot_primary_btn') }} !important;
            @endif
        }

        .section-tittle-two .title{
            font-size: 16px !important;
        }
        .h4, h4,
        .h5, h5,
        .h6, h6{
            font-size: 14px !important;
        }
        .comment_area .comment_list_wrapper .comment_list_single .comment_list_single_info h4{
            font-size: 14px !important;
        }
        .course-details-tabs .nav-item .nav-link span{
            font-size: 12px !important;
        }
        .course-details-tabs{
            grid-gap: 10px !important;
        }
        .small-tittle-two .title{
            font-size: 14px !important;
        }
        .btn-primary-fill{
            padding: 10px 16px !important;
            font-size: 12px !important;
        }
        .assignment-area .single-list-assignment .title{
            font-size: 12px !important;
        }

        .small, small,
        .noticeboard-list.accordion-list li div.answer p{
            font-size: 12px !important;
        }

        .accordion-button:not(.collapsed){
            background-color: #ffffff;
        }
    </style>
</head>

<body class="light-mode">
<main>
    <!-- Admin Contents S t a r t -->
    <div class="container-fluid">
        <div class="admin-wrapper p-0">

            <!-- Playlist Header  S t a r t-->
            <div data-id="{{ encryptFunction(@$data['enroll']->id) }}" class="enroll-id sidebar-body-overlay"></div>


            <!-- End-of Playlist Header -->

            <!--playlist wrapper  -->
            <div class="playlist-wrapper">
                <div class="container-fluid">
                    <div class="row flex-column-reverse flex-lg-row">
                        <!-- Right side Playlist  -->
                        <div class="white-bg mt-3">
                            <!-- Single Video -->
                            <div class="video-section radius-10 overflow-hidden mb-40">
                                @if (@$data['lesson'])
                                @if (@$data['lesson']->is_quiz == 1)
                                    <div class="quize-text-wrapper ot-card white-bg mb-24" id="quiz_load"
                                        data-url="{{ route('student.quiz', [encryptFunction(@$data['lesson']->id)]) }}">


                                    </div>
                                @else
                                    @if (@$data['lesson']->lesson_type == 'Youtube')
                                        <div class="container video-size ">
                                            <div class="plyr__video-embed" id="player">
                                                <iframe id="player" type="text/html" height="500" width="100%"
                                                    src="https://www.youtube.com/embed/{{ course_video_url_preg_match(@$data['lesson']->video_url) }}"
                                                    allowfullscreen allowtransparency allow="autoplay"></iframe>
                                            </div>
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'Vimeo')
                                        <div class="container video-size">
                                            <div class="plyr__video-embed" id="player">
                                                <iframe
                                                    src="https://player.vimeo.com/video/{{ course_video_url_preg_match(@$data['lesson']->video_url) }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"></iframe>
                                            </div>
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'GoogleDrive')
                                        <div class="container video-size">
                                            <div class="plyr__video-embed" id="player">
                                                <iframe width="100%" height="500px"
                                                    src="https://drive.google.com/file/d/{{ course_video_url_preg_match(@$data['lesson']->video_url) }}/preview"
                                                    allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'VideoFile')
                                        <div class="container video-size">
                                            <video playsinline controls width="100%" height="500px">
                                                @if (video_get_video_extension(@$data['lesson']->video->original) == 'mp4')
                                                    <source src="{{ asset(@$data['lesson']->video->original) }}" />
                                                @elseif (video_get_video_extension(@$data['lesson']->video->original) == 'webm')
                                                    <source src="{{ asset(@$data['lesson']->video->original) }}"
                                                        type="video/webm" />
                                                @endif
                                            </video>
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'Text')
                                        <div class="container video-size border al">
                                            <div class="justify-content-center pt-50 pb-50">
                                                <p><?= @$data['lesson']->lesson_text ?></p>
                                            </div>
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'ImageFile')
                                        <div class="container video-size">
                                            <img src="{{ showImage(@$data['lesson']->image->original) }}" alt="image"
                                                width="100%" height="500px">
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'DocumentFile' && @$data['lesson']->attachment_type == 1)
                                        <div class="container video-size">
                                            <iframe src="{{ showImage(@$data['lesson']->attachmentFile->original) }}"
                                                width="100%" height="500px" frameborder="0"></iframe>
                                        </div>
                                    @elseif (@$data['lesson']->lesson_type == 'DocumentFile' && @$data['lesson']->attachment_type == 2)
                                        <div class="container video-size">
                                            <iframe class="doc" width="100%" height="500px"
                                                src="https://docs.google.com/gview?url={{ showImage(@$data['lesson']->attachmentFile->original) }}&embedded=true"></iframe>
                                        </div>
                                    @endif
                                @endif
                                @else
                                    <div class="container video-size">
                                        <img src="{{ showImage("") }}" alt="image" width="100%" height="500px">
                                    </div>
                                @endif
                            </div>
                            <!--Video-description  -->
                            <div class="video-description mb-40">
                                <div
                                    class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                                    <h2 class="title font-600 mb-20">{{ @$data['enroll']->course->title }}</h2>
                                </div>

                                <div class="d-flex course-author gap-12 align-items-center">
                                    <div class="thumb course-widget-author-img">
                                        <img class="img-cover"
                                            src="{{ showImage(@$data['enroll']->course->user->image->original) }}"
                                            alt="img">
                                    </div>
                                    <div class="author-info">
                                        <h5>{{ @$data['enroll']->course->user->name }}</h5>
                                        @if (@$data['enroll']->course->user->instructor)
                                            <p class="text-gray text-12 font-400 line-clamp-1">
                                                {{ @$data['enroll']->course->user->instructor->designation }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Video Review TAB-->
                            <ul class="nav course-details-tabs mb-40 d-flex justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link learn-tab active" id="Overview-tab" data-bs-toggle="tab"
                                        data-id="Overview" data-bs-target="#Overview" type="button" role="tab"
                                        aria-controls="Overview" aria-selected="true">
                                        <i class="ri-dashboard-line"></i>
                                        <span>{{ ___('student.Overview') }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link learn-tab" id="Notes-tab" data-bs-toggle="tab"
                                        data-bs-target="#Notes" data-id="Notes" type="button" role="tab"
                                        aria-controls="Notes" aria-selected="false">
                                        <i class="ri-edit-2-line"></i>
                                        <span>{{ ___('student.Notes') }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link learn-tab" id="Review-tab" data-bs-toggle="tab"
                                        data-bs-target="#Review" data-id="Review" type="button" role="tab"
                                        aria-controls="Review" aria-selected="false">
                                        <i class="ri-star-line"></i>
                                        <span>{{ ___('student.Reviews') }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link learn-tab" id="Announcement-tab" data-bs-toggle="tab"
                                        data-id="Announcement" data-bs-target="#Announcement" type="button"
                                        role="tab" aria-controls="Announcement" aria-selected="false">
                                        <i class="ri-notification-line"></i>
                                        <span>{{ ___('student.Announcements') }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link learn-tab" id="assignment-tab" data-bs-toggle="tab"
                                        data-bs-target="#Assignment" type="button" role="tab"
                                        data-id="Assignment" aria-controls="Assignment" aria-selected="false">
                                        <i class="ri-tools-line"></i>
                                        <span>{{ ___('student.Assignments') }}</span>
                                    </button>
                                </li>
                            </ul>
                            <!-- Video Review Content -->
                            <div class="tab-content course-play" id="myTabContent">

                                <div class="tab-pane fade show active" id="Overview" role="tabpanel"
                                    aria-labelledby="Overview-tab">

                                    @if (@$data['enroll']->course->outcomes)
                                        <!-- course tab s t a r t  -->
                                        <div class="course-tab-widget">
                                            <h3 class="course-details-title">
                                                {{ ___('frontend.What You will Learn From This course') }}</h3>
                                            <ul class="course-details-list">
                                                <?= @$data['enroll']->course->outcomes ?>
                                            </ul>
                                        </div>
                                        <!--End-of course tab  -->
                                    @endif

                                    @if (@$data['lesson']->content)
                                        <!-- course content s t a r t  -->
                                        <div class="course-tab-widget">
                                            <h3 class="course-details-title">{{ ___('frontend.Lecture Content') }}
                                            </h3>
                                            <ul class="course-details-list">
                                                <?= @$data['lesson']->content ?>
                                            </ul>
                                        </div>
                                        <!--End-of content tab  -->
                                    @endif


                                </div>
                                <div class="tab-pane fade " id="Notes" role="tabpanel"
                                    aria-labelledby="Notes-tab">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20">
                                                <!-- Section Tittle -->
                                                <div class="small-tittle-two mb-20">
                                                    <h2 class="title font-600 text-capitalize">
                                                        {{ ___('student.Notes') }}</h2>
                                                </div>
                                                <button class="btn-primary-fill mb-20"
                                                    onclick="mainModalOpen(`{{ route('student.note.create', [encryptFunction(@$data['lesson']->id)]) }}`)">{{ ___('student.Create') }}</button>
                                            </div>
                                        </div>
                                        <span id="notes_list">
                                        </span>

                                    </div>
                                </div>
                                <div class="tab-pane fade " id="Review" role="tabpanel"
                                    aria-labelledby="Review-tab">
                                    <!-- CONTENT:START  -->
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20">
                                                <!-- Section Tittle -->
                                                <div class="small-tittle-two mb-20">
                                                    <h2 class="title font-600 text-capitalize">
                                                        {{ ___('student.Reviews') }}</h2>
                                                </div>
                                            </div>
                                            <div class="comment_area">
                                                <div class="comment_list_wrapper" id="reviews_list">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- CONTENT:END    -->
                                </div>

                                <div class="tab-pane fade " id="Announcement" role="tabpanel"
                                    aria-labelledby="Announcement-tab">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20">
                                                <!-- Section Tittle -->
                                                <div class="small-tittle-two mb-20">
                                                    <h2 class="title font-600 text-capitalize">
                                                        {{ ___('student.Announcements') }}</h2>
                                                </div>
                                            </div>

                                            <div class="comment_area">
                                                <div class="comment_list_wrapper">
                                                    <ul class="accordion-list noticeboard-list">
                                                        @forelse (@$data['enroll']->course->noticeBoards as $noticeBoard)
                                                            {{-- Single Notice --}}
                                                            <li>
                                                                <h6 class="font-500">{{ $noticeBoard->title }}</h6>
                                                                <small>{{ showDate($noticeBoard->created_at) }}
                                                                </small>
                                                                <div class="answer mt-20">
                                                                    <p>
                                                                        <?= $noticeBoard->description ?>
                                                                    </p>

                                                                </div>
                                                            </li>
                                                            {{-- Single Notice --}}

                                                        @empty
                                                            <li class="border-0">
                                                                <h6 class="font-500 text-center text-tertiary">
                                                                    {{ ___('student.No_Notice_Found') }}</h6>
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!-- assignment-tab -->
                                <div class="tab-pane fade " id="Assignment" role="tabpanel"
                                    aria-labelledby="assignment-tab">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20">
                                                <!-- Section Tittle -->
                                                <div class="small-tittle-two mb-20">
                                                    <h2 class="title font-600 text-capitalize">
                                                        {{ ___('student.Assignments') }}</h2>
                                                </div>
                                            </div>
                                            <ul class="assignment-area" id="assignments_list">

                                            </ul>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- End-of Video Review -->
                        </div>
                        <!-- End-of Right side Playlist -->

                    </div>
                    <!-- Menu Sections Start -->
                            <div class="listing-video-wrapper nice-scroll mt-5">
                                <div class="accordion" id="accordionExample2">
                                    <!-- Single  -->
                                    @foreach ($data['enroll']->course->sections as $key => $section)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $key }}">
                                                <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $key }}" aria-expanded="true"
                                                    aria-controls="collapse{{ $key }}">
                                                    <h5 class="title"> {{ @$section->title }}</h5>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $key }}"
                                                class="accordion-collapse collapse {{ in_array(@$data['lesson_id'], $section->allLesson->pluck('id')->toArray()) ? 'show' : '' }}"
                                                aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <!-- listing video -->
                                                    <ul class="listing-video">
                                                        <!-- Single video -->
                                                        @foreach ($section->allLesson as $lesson)
                                                            <li
                                                                class="single-list {{ @$lesson->id == @$data['lesson_id'] ? ' active' : '' }} ">
                                                                <div class="mb-8  d-flex align-items-center w-100">
                                                                    @if ($lesson->is_quiz)
                                                                        <div class="check-remember-me">
                                                                            <label>
                                                                                <input class="ot-checkbox" type="checkbox"
                                                                                    {{ in_array(@$lesson->id, $enroll->completed_quizzes ?? []) ? 'checked' : '' }} />
                                                                                <span class="ot-checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                    @else
                                                                        <div class="check-remember-me" id="lesson-progress"
                                                                            data-id="{{ encryptFunction(@@$lesson->id) }}">
                                                                            <label>
                                                                                <input class="ot-checkbox" type="checkbox"
                                                                                    name="lesson_id[]"
                                                                                    value="{{ encryptFunction(@@$lesson->id) }}"
                                                                                    {{ in_array(@$lesson->id, $enroll->completed_lessons ?? []) ? 'checked' : '' }} />
                                                                                <span class="ot-checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                    <div class="d-flex align-items-center w-100" id="lesson-start"
                                                                        data-id="{{ encryptFunction(@@$lesson->id) }}">
                                                                        <div class="play-btn">
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
                                                                        </div>
                                                                        <h6 class="title"> {{ @$lesson->title }} </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        <!-- Single video -->
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- Single -->
                                </div>
                            </div>
                        <!-- Menu Sections End -->
                </div>
            </div>
            <!-- End-of playlist wrapper -->
        </div>
    </div>
    <!--End-of Admin Contents -->
</main>
@include('frontend.partials.lang-static')
<!-- toastr js-->

<script src="{{ url('frontend/assets/js/jquery-3.7.0.min.js') }} "></script>
<script src="{{ url('frontend/assets/js/popper.min.js') }} "></script>
<script src="{{ url('frontend/assets/js/bootstrap-5.3.0.min.js') }} "></script>
<!-- Plugin -->
<script src="{{ url('frontend/assets/js/plugin.js') }} "></script>
@include('backend.partials.alert-message')
<!-- multiple image upload -->
<script src="{{ asset('backend') }}/assets/js/multi_image.js"></script>
<!-- multiple image upload -->

<!-- Main js-->
<script src="{{ url('frontend/assets/js/main.js') }} "></script>
<script src="{{ asset('backend') }}/assets/js/ckeditor.js"></script>
<script src="{{ url('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/plyr/plyr.js') }}"></script>
    <script src="{{ asset('frontend/js/student/main.js') }}" type="module"></script>
    @if (@$data['lesson']->is_quiz == 1)
        <script src="{{ asset('frontend/js/student/quiz.js') }}" type="module"></script>
    @endif
</body>

</html>
