@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')
    <style>
        .form-control { margin-bottom: 10px; }
        .tab-pane { padding-top: 15px; }
        input, textarea {
            text-transform: none !important;
        }
    </style>

    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--Bradcam S t a r t -->

    <!-- End-of Breadcrumb-->
    <div class="multi-step-form section-padding">
        <div class="container">
            <section style="font-family: Arial, sans-serif; padding: 40px; background-color: #f9f9f9;">
                <h2 style="text-align: center; font-size: 32px; margin-bottom: 20px;">🎓 Ambassador Benefits</h2>

                <p style="text-align: center; font-size: 16px; max-width: 700px; margin: 0 auto 40px;">
                    Become an official LMS Ambassador and enjoy exclusive rewards for promoting our courses and growing our community.
                </p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>💰 Course-wise Commission</h3>
                        <p>Earn a fixed percentage from every course sale made through your referral link.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>🎓 Free or Discounted Courses</h3>
                        <p>Enjoy free or special access to premium courses to boost your learning and promotions.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>🎁 Performance Bonuses</h3>
                        <p>Get monthly rewards or bonuses for achieving referral milestones.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>🏅 Badge & Certificate</h3>
                        <p>Receive an official Ambassador badge and a shareable digital certificate.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>📊 Referral Dashboard</h3>
                        <p>Track your referrals, earnings, and performance in a dedicated dashboard.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>🤝 Exclusive Events</h3>
                        <p>Get invites to special webinars, workshops, and ambassador-only sessions.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>🌟 Social Media Recognition</h3>
                        <p>Top ambassadors are featured on our social media and website for added exposure.</p>
                    </div>

                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h3>💬 Community Leadership</h3>
                        <p>Opportunities to become a mentor, moderator, or leader within our learner community.</p>
                    </div>

                </div>
            </section>

            <section>
                <div class="row justify-content-center">
                    <div class="col-12">
            <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-12">
                <div class="about-caption mb-24 mt-24">
                    <h3 class="title font-600">{{ ___('frontend.Become an Ambassador') }}</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registrationModal">
                        Open Registration Form
                    </button>
                </div>
            </div>
            </div>
            </div>
            </section>
            <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ambassador Registration</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="formTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Basic Information</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button" role="tab">Question</button>
                                </li>
                            </ul>

                            <!-- Form -->
                            <form action="{{ route('ambassador.sign_up') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content">
                                    <!-- Basic Info Tab -->
                                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="name" placeholder="*Name" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="phone" placeholder="*Contact Number" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control" name="email" placeholder="*Email" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input class="form-control" name="password" type="password" placeholder="Enter Password " required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="facebook_id" placeholder="Facebook profile">
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="university" placeholder="*University" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="graduation_year" placeholder="*Graduation Year" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="linkedin_id" placeholder="LinkedIn profile">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="instagram_id" placeholder="Instagram profile">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="quora_id" placeholder="Quora profile">
                                                </div>
                                            </div>
                                        </div>
                                        <button id="nextBtn" class="btn btn-success mt-2" type="button">Next</button>
                                    </div>

                                    <!-- Question Tab -->
                                    <div class="tab-pane fade" id="question" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="questions[0][title]" value="How will you kick off your campaign?">
                                                <textarea class="form-control mb-3" name="questions[0][answer]" style="height: 80px;" placeholder="How will you kick off your campaign?"></textarea>

                                                <input type="hidden" name="questions[1][title]" value="How being 'Campus Ambassador' will help in your development?">
                                                <textarea class="form-control mb-3" name="questions[1][answer]" style="height: 80px;" placeholder="How being 'Campus Ambassador' will help in your development?"></textarea>

                                                <input type="hidden" name="questions[2][title]" value="Why you choose to be a campus ambassador?">
                                                <textarea class="form-control mb-3" name="questions[2][answer]" style="height: 80px;" placeholder="Why you choose to be a campus ambassador?"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" name="questions[3][title]" value="What are your suggestion for improvement?">
                                                <textarea class="form-control mb-3" name="questions[3][answer]" style="height: 80px;" placeholder="What are your suggestion for improvement?"></textarea>

                                                <input type="hidden" name="questions[4][title]" value="What are your thought about the future of Edu tech Company?">
                                                <textarea class="form-control mb-3" name="questions[4][answer]" style="height: 80px;" placeholder="What are your thought about the future of Edu tech Company?"></textarea>

                                                <input type="hidden" name="questions[5][title]" value="What are your thought about the future of programming in Bangladesh?">
                                                <textarea class="form-control mb-3" name="questions[5][answer]" style="height: 80px;" placeholder="What are your thought about the future of programming in Bangladesh?"></textarea>
                                            </div>
                                        </div>

                                        <div class="mb-3 mt-2">
                                            <label class="form-label">Upload resume</label>
                                            <input type="file" name="cv" class="form-control">
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-secondary" type="button" id="previousBtn">Previous</button>
                                            <button class="btn btn-success" type="submit">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script>
    // Activate "Question" tab on Next click
    document.getElementById('nextBtn').addEventListener('click', function () {
        let tabTrigger = new bootstrap.Tab(document.querySelector('#question-tab'));
        tabTrigger.show();
    });

    // Activate "Basic" tab on Previous click
    document.getElementById('previousBtn').addEventListener('click', function () {
        let tabTrigger = new bootstrap.Tab(document.querySelector('#basic-tab'));
        tabTrigger.show();
    });
</script>
@endsection
