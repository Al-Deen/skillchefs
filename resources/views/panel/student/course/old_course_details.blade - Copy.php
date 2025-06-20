@extends('panel.student.layouts.course_master')
@section('title', @$data['title'])
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/plyr/plyr.css') }}" />
@endsection
<style>
    #lesson-video {
        position: relative;
        z-index: 1;
        overflow: hidden; /* ensures watermark doesn't go outside */
    }

    .video-watermark {
        position: absolute;
        color: red !important; /* 🔴 Text color red */
        font-size: 14px;
        z-index: 10;
        pointer-events: none;
        transition: all 1s ease-in-out;
    }
</style>
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
                                            <div class="container video-size " id="lesson-video">
                                                <div class="plyr__video-embed" id="player">
                                                    <iframe id="player" type="text/html" height="500" width="100%"
                                                        src="https://www.youtube.com/embed/{{ course_video_url_preg_match(@$data['lesson']->video_url) }}"
                                                        allowfullscreen allowtransparency allow="autoplay"></iframe>
                                                </div>
                                                <div class="video-watermark" id="watermark-text">
                                                   <p style="color: red">{{ Auth::user()->email }}</p>  <p style="color: red;text-align: center">{{ Auth::user()->phone }}</p>
                                                </div>
                                            </div>

                                        @elseif (@$data['lesson']->lesson_type == 'Vimeo')
                                            <div class="container video-size" id="lesson-video">
                                                <div class="plyr__video-embed" id="player">
                                                    <iframe
                                                        src="https://player.vimeo.com/video/{{ course_video_url_preg_match(@$data['lesson']->video_url) }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"></iframe>
                                                </div>
                                                <div class="video-watermark" id="watermark-text">
                                                    <p style="color: red">{{ Auth::user()->email }}</p>  <p style="color: red;text-align: center">{{ Auth::user()->phone ?? '' }}</p>
                                                </div>
                                            </div>
                                        @elseif (@$data['lesson']->lesson_type == 'GoogleDrive')
                                            <div class="container video-size" id="lesson-video">
                                                <div class="plyr__video-embed" id="player">
                                                    <iframe width="100%" height="500px"
                                                        src="https://drive.google.com/file/d/{{ course_video_url_preg_match(@$data['lesson']->video_url) }}/preview"
                                                        allowfullscreen></iframe>
                                                </div>
                                                <div class="video-watermark" id="watermark-text">
                                                    <p style="color: red">{{ Auth::user()->email }}</p>  <p style="color: red;text-align: center">{{ Auth::user()->phone ?? '' }}</p>
                                                </div>
                                            </div>
                                        @elseif (@$data['lesson']->lesson_type == 'VideoFile')
                                            <div class="container video-size" id="lesson-video">
                                                <video playsinline controls width="100%" height="500px">
                                                    @if (video_get_video_extension(@$data['lesson']->video->original) == 'mp4')
                                                        <source src="{{ asset(@$data['lesson']->video->original) }}" />
                                                    @elseif (video_get_video_extension(@$data['lesson']->video->original) == 'webm')
                                                        <source src="{{ asset(@$data['lesson']->video->original) }}"
                                                            type="video/webm" />
                                                    @endif
                                                </video>
                                                <div class="video-watermark" id="watermark-text">
                                                    <p style="color: red">{{ Auth::user()->email }}</p>  <p style="color: red;text-align: center">{{ Auth::user()->phone ?? '' }}</p>
                                                </div>
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
                                            <div class="container video-size" id="watermark-text" >
                                                <div class="plyr__video-embed" id="player">
                                                    <iframe width="100%" height="500px" src="{{ @$data['lesson']->iframe }}"></iframe>
                                                </div>
                                                <div class="video-watermark" id="watermark-text">
                                                    <p style="color: red">{{ Auth::user()->email }}</p>  <p style="color: red;text-align: center">{{ Auth::user()->phone ?? '' }}</p>
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

                                    <div class="d-flex course-author gap-3 align-items-center">
                                        <!-- Author Image -->
                                        <div class="thumb course-widget-author-img">
                                            <img class="img-cover"
                                                 src="{{ showImage(@$data['enroll']->course->user->image->original) }}"
                                                 alt="img">
                                        </div>

                                        <!-- Author Info -->
                                        <div class="author-info">
                                            <h5>{{ @$data['enroll']->course->user->name }}</h5>
                                            @if (@$data['enroll']->course->user->instructor)
                                                <p class="text-gray text-12 font-400 line-clamp-1">
                                                    {{ @$data['enroll']->course->user->instructor->designation }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Copyright Warning -->
                                        <div class="ms-auto">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#copyrightModal"
                                               class="text-danger d-flex align-items-center" style="margin-right: 30px; text-decoration: none;">
                                                <span class="me-1">⚠️</span>
                                                <span style="text-decoration: underline;">Copyright warning</span>
                                            </a>
                                        </div>


                                        <div class="modal fade" id="copyrightModal" tabindex="-1" aria-labelledby="copyrightModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg"> <!-- Bigger modal -->
                                                <div class="modal-content">
                                                    <div class="modal-header border-0">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-5 text-center">
                                                        <img src="{{ showImage('') }}" alt="Warning" class="mb-2" style="width: 100px;">

                                                        <p class="text-danger" style="text-align: justify; line-height: 1.4; font-size: 14px;">
                                                            Skillchefs এর সাথে সম্পৃক্ত যেকোনো ভিডিও, টেক্সট বা কনটেন্ট অন্য কারো সাথে বিনিময় বা বিনামূল্যে আপলোড-শেয়ার করা, কিংবা সাথে ইমেইল-একাউন্ট শেয়ারিং করার মাধ্যমে অন্যকে প্রবেশাধিকার দেয়া আইনত অপরাধ এবং ৪ থেকে ১৪ বছরের জেল হতে পারে। শুধু তাই না, আপনি যদি কাউকে সাহায্য করেন, তাহলেও আপনি আইনের চোখে সমান অপরাধী হিসেবে বিবেচিত হবেন।
                                                            <br><br>
                                                            সাইবার সিকিউরিটি কেউ একা নিশ্চিত করতে পারে না। সবার মাঝে সচেতনতা তৈরি করতে হবে। সবারই একে অপরকে উৎসাহিত করতে হবে। খেয়াল রাখতে হবে, কেউ টাকার লোভে অবৈধ কাজ করে ফেলছে কিনা!
                                                            <br><br>
                                                            অন্য নামে একাউন্ট খুলে ব্রাউজার এক্সটেনশন ইনস্টল করে কনটেন্ট এক্সেস করে আবার ইনস্টলেশন খুলে ফেলা (কোনোটাই বৈধ নয়) যায় না। এমনটি যদি দেখা যায় তাহলে তুমি নিজেও ঝুঁকির মধ্যে পড়বে। তোমার ISP, আইপি এড্রেস, লোকেশন, ডিভাইস আইডি থেকে সমস্ত ডেটা খুঁজে বের করে তোমাকে সনাক্ত করা সম্ভব। বর্তমানে জিরো ট্রাস্ট নেটওয়ার্কিং করা হচ্ছে যাতে প্রত্যেক ইউজারের একাউন্ট কোন আইপি বা লোকেশন থেকে ব্যবহার হচ্ছে সেটা ট্র্যাকিং সম্ভব। সুতরাং কোনো চেষ্টা করার আগেই থেমে যাও (বিপদ থেকে বাঁচো)
                                                            <br><br>
                                                            আমরা অনলাইন ধরে চিহ্নিত করে দুই-একজনকে উদাহরণ হিসেবে রেখে সবাইকে জানিয়ে দিব যাতে সবাই টের পায় সংক্রান্ত হতে যাওয়া বিপদটা। তুমি যদি নিজেকে ও তোমার পরিবারকে ভালোবাসো, তাহলে এমন কিছুতে জড়িও না যেটা ভবিষ্যতের জন্য তোমার এবং তোমার পরিবারের জন্য চিন্তার কারণ।
                                                            <br><br>
                                                            <strong>একবার কেউ ধরা গেলে কিন্তু তোমাকে বাঁচাতে আসবে না।</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
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

                                  @if(isset($data['aciveLiveSupportData']))

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link learn-tab" id="Support-tab" type="button"
                                                data-bs-toggle="modal" data-bs-target="#supportMeetModal" >
                                            <i class="ri-live-line"></i>
                                            <span>{{ ___('student.Support') }}</span>
                                        </button>
                                    </li>
                                    @else

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link learn-tab" id="Support-tab" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#supportModal">
                                                <i class="ri-live-line"></i>
                                                <span>{{ ___('student.Support') }}</span>
                                            </button>
                                        </li>


                                    @endif


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
                                        <div class="ro  w">
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

                                    <div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 pb-2 d-flex flex-column align-items-center">
                                                    <h5 class="modal-title text-primary fw-bold" id="supportModalLabel" style="font-size: 20px;">
                                                        <i class="ri-customer-service-2-line me-2"></i> Support Registration
                                                    </h5>
                                                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                @if(@$data['support'])

                                                <div class="modal-body">
                                                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 bg-white">
                                                        <h6 class="text-center text-primary fw-bold mb-2" style="font-size: 16px;">
                                                            <i class="ri-calendar-event-line me-2"></i>
                                                            Meeting Title: {{ @$data['support']->title ?? 'N/A' }}
                                                        </h6>

                                                        <p class="text-center mb-2 text-muted" style="font-size: 13px;">
                                                            <strong><i class="ri-user-line me-1"></i> Instructor:</strong>
                                                            {{ @$data['enroll']->course->user->name ?? 'N/A' }}
                                                        </p>

                                                        <div class="row text-center" style="font-size: 13px;">
                                                            <div class="col-6 border-end">
                                                                <div class="text-success fw-semibold">Session Start</div>
                                                                <div>
                                                                    {{ @$data['support']->start_time ? \Carbon\Carbon::parse($data['support']->start_time)->format('h:i A') : 'N/A' }}
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-danger fw-semibold">Session End</div>
                                                                <div>
                                                                    {{ @$data['support']->end_time ? \Carbon\Carbon::parse($data['support']->end_time)->format('h:i A') : 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form id="supportRegistrationForm" action="{{ route('student.support.request') }}" method="POST" class="p-3 rounded-3">
                                                        @csrf

                                                        <input type="hidden" name="support_id" value="{{ @$data['support']->id }}">
                                                        <input type="hidden" name="course_id" value="{{ @$data['support']->course_id }}">
                                                        <div class="mb-3">
                                                            <label for="question" class="form-label fw-semibold">
                                                                <i class="ri-question-answer-line me-1"></i> Your Question / Issue
                                                            </label>
                                                            <textarea
                                                                class="form-control border rounded-2"
                                                                id="question"
                                                                name="question"
                                                                rows="8"
                                                                placeholder="Write your issue or question clearly..."
                                                                required
                                                                style="font-size: 14px; resize: none; min-height: 150px;"
                                                            ></textarea>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                                                <i class="ri-send-plane-line me-1"></i> Submit Request
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                                @else
                                                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px 20px; border-radius: 8px; max-width: 400px; margin: 20px auto; text-align: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                        <h6 style="color: red; font-weight: 600; font-size: 1.1rem; margin: 0;">
                                                            Support is currently unavailable. Please check back later.
                                                        </h6>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                          {{--   join support  show --start--}}
                                    <div class="modal fade" id="supportMeetModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4">

                                                @if(isset($data['liveSupportData']))
                                                    <div class="modal-body text-center p-4">
                                                        <p class="mb-1 text-muted small">
                                                        <h4 class="text-secondary">{{ $data['liveSupportData']->support?->title }}</h4>
                                                        <h5 class="text-secondary">Course: {{  $data['liveSupportData']->support?->course->title }}</h5>
                                                        <strong>Instructor:</strong> {{ $data['liveSupportData']->support?->user->name }}<br>
                                                        </p>

                                                        @if( @$data['liveSupportData']->status == 0)

                                                        <h5 class="fw-bold mb-0">Your Serial</h5>
                                                        <h2 class="display-4 fw-bold mb-3">{{ $data['liveSupportSerial'] ?? 'N/A' }}</h2>
                                                        <p class="text-muted small mb-4">
                                                            Your support will begin in approximately   <strong class="text-primary">{{ $data['waitingTime'] ?? 'N/A' }}</strong> minutes.
                                                        </p>
                                                        @endif

                                                        <div class="d-flex justify-content-between mx-5 mb-4">
                                                            <div>
                                                                <div class="text-success fw-bold">Session Start</div>
                                                                <div>
                                                                    {{ @$data['liveSupportData']->support?->start_time ? \Carbon\Carbon::parse(@$data['liveSupportData']->support?->start_time)->format('h:i A') : 'N/A' }}
                                                                </div>

                                                            </div>
                                                            <div>
                                                                <div class="text-danger fw-bold">Session End</div>
                                                                <div>  {{ @$data['liveSupportData']->support?->end_time ? \Carbon\Carbon::parse(@$data['liveSupportData']->support?->end_time)->format('h:i A') : 'N/A' }}</div>
                                                            </div>
                                                        </div>

                                                        <!-- Buttons -->
                                                        <div class="d-flex justify-content-center gap-10">
                                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Leave</button>
                                                            <a target="_blank" href="{{  @$data['liveSupportData']->support?->support_link }}" class="btn btn-primary px-4">Join Now</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px 20px; border-radius: 8px; max-width: 400px; margin: 20px auto; text-align: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                        <h6 style="color: red; font-weight: 600; font-size: 1.1rem; margin: 0;">
                                                            Support is currently unavailable. Please check back later.
                                                        </h6>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    {{-- join support  show --end--}}



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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const watermark = document.getElementById("watermark-text");

            setInterval(() => {
                const container = document.getElementById("lesson-video");
                const containerWidth = container.clientWidth;
                const containerHeight = container.clientHeight;

                const maxLeft = containerWidth - watermark.clientWidth - 15;
                const maxTop = containerHeight - watermark.clientHeight - 15;

                const randomLeft = Math.floor(Math.random() * maxLeft) + 15;
                const randomTop = Math.floor(Math.random() * maxTop) + 15;

                watermark.style.left = randomLeft + "px";
                watermark.style.top = randomTop + "px";
            }, 3000); // every 3 seconds it will move
        });
    </script>


    @if(isset($data['aciveLiveSupportData']))
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const supportModal = new bootstrap.Modal(document.getElementById('supportMeetModal'));
            supportModal.show();
        });
     </script>
    @endif


@endsection
