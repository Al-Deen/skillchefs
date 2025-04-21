@extends('panel.student.layouts.course_master')
@section('title', @$data['title'])
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/plyr/plyr.css') }}" />
@endsection
@section('content')
    <main>
        <!-- Admin Contents S t a r t -->
        <div class="container-fluid">
            <div class="admin-wrapper p-0">

                <!-- Playlist Header  S t a r t-->
                <div data-id="{{ encryptFunction(@$data['enroll']->id) }}" class="enroll-id sidebar-body-overlay"></div>
                <!-- Playlist Banner S t a r t -->
                <div class="playlist-banner mb-24">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div
                                    class="playlist-banner-wrapper d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="d-flex align-items-center">
                                        <!-- Mobile Device sidebar open Icon -->
                                        <div class="panel-sidebar-icon">
                                            <div class="sidebar-icon"><i class="ri-arrow-left-right-line"></i></div>
                                        </div>
                                        <a href="{{ route('home') }}" class="panel-home">
                                            <i class="ri-home-4-line"></i>
                                        </a>
                                        <a href="{{ route('student.dashboard') }}" class="panel-home">
                                            <i class="ri-dashboard-line"></i>
                                        </a>
                                    </div>
                                    <ul class="listing d-flex flex-wrap ">
                                        <li class="single-list font-500 d-flex">
                                            <!-- Progress Ratting -->
                                            <div class="progress-container d-inline mr-10">
                                                <div class="progress" data-percentage="{{ @$data['enroll']->progress }}">
                                                    <span class="progress-left">
                                                        <span class="progress-bar progress-c-sub-title"></span>
                                                    </span>
                                                    <i class="ri-trophy-line"></i>
                                                    <span class="progress-right">
                                                        <span class="progress-bar progress-c-sub-title"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- /End -->
                                            <span class="cap"> {{ ___('student.Your Progress') }} </span>
                                        </li>

                                        <!-- Dark & Light Mode -->
                                        <li class="single-list">
                                            <button class="single-list single change-mode p-0 m-0 border-0 dark-mode">
                                                <i class="ri-sun-line"></i>
                                            </button>
                                        </li>
                                        
                                        <li class="single-list font-500 pb-10">
                                            <a href="javascript:void(0)"
                                                onclick="mainModalOpen(`{{ route('student.review.create', [encryptFunction(@$data['enroll']->id)]) }}`)"
                                                class="share-btn">
                                                <i class="ri-star-line"></i>
                                                <span class="cap">{{ ___('student.Review') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End-of Playlist Banner -->

                <!-- End-of Playlist Header -->

                <!--playlist wrapper  -->
                <div class="playlist-wrapper">
                    <div class="container-fluid">
                        <div class="row flex-column-reverse flex-lg-row">
                            <!-- Left side Panel Sidebar Start -->
                            @include('panel.student.partials.playlist_sidebar', [
                                'enroll' => $data['enroll'],
                            ])
                            <!-- End-of Panel Sidebar -->

                            <!-- Right side Playlist  -->
                            <div class="playlist-right-side white-bg">
                                <!-- Single Video -->
                                <div class="video-section radius-10 overflow-hidden mb-40">
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
                                        @elseif (@$data['lesson']->lesson_type == 'IframeEmbed' )
                                            <div class="container video-size">
                                                <div class="plyr__video-embed" id="player">
                                                    <iframe width="100%" height="500px" src="{{ @$data['lesson']->iframe }}"></iframe>
                                                </div>
                                            </div>
                                        @elseif (@$data['lesson']->lesson_type == 'DocumentFile' && @$data['lesson']->attachment_type == 2)
                                            <div class="container video-size">
                                                <iframe class="doc" width="100%" height="500px"
                                                    src="https://docs.google.com/gview?url={{ showImage(@$data['lesson']->attachmentFile->original) }}&embedded=true"></iframe>
                                            </div>
                                        @endif
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
                                <ul class="nav course-details-tabs mb-40" id="myTab" role="tablist">
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
                    </div>
                </div>
                <!-- End-of playlist wrapper -->
            </div>
        </div>
        <!--End-of Admin Contents -->
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('frontend/plyr/plyr.js') }}"></script>
    <script src="{{ asset('frontend/js/student/main.js') }}" type="module"></script>
    @if (@$data['lesson']->is_quiz == 1)
        <script src="{{ asset('frontend/js/student/quiz.js') }}" type="module"></script>
    @endif
@endsection
