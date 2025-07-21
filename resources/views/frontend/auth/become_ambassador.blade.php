@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('content')
    <style>
        .form-control { margin-bottom: 10px; }
        .tab-pane { padding-top: 15px; }
        input, textarea {
            text-transform: none !important;
        }


        .ambassador-card {
            background: transparent;
            text-align: center;
            padding: 10px;
        }

        .ambassador-img-box {
            background-color: #fff;
            padding: 15px 10px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            width: 180px;
            margin: 0 auto 12px auto;
            position: relative;
        }

        .ambassador-img-box img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .ambassador-role {
            font-size: 14px;
            font-weight: 500;
            margin-top: 10px;
            color: #333;
        }

        .ambassador-name {
            font-size: 16px;
            font-weight: 700;
            color: #ffc107; /* golden-yellow */
            margin-bottom: 4px;
        }

        .ambassador-designation {
            font-size: 13px;
            color: #eee;
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
                <h2 style="text-align: center; font-size: 32px; margin-bottom: 20px;">🎓 {{ @$data['ambassador_settings']?->title }}</h2>

                <p style="text-align: center; font-size: 16px; max-width: 700px; margin: 0 auto 40px;">
                    {{ @$data['ambassador_settings']?->description }}
                </p>
                @php

                     $data['point_title']  = json_decode( $data['ambassador_settings']?->point_title);
                     $data['point_description']  = json_decode( $data['ambassador_settings']?->point_description);
                     $data['questions']  = json_decode( $data['ambassador_settings']?->questions);

                @endphp

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    @if(is_array($data['point_title']))
                        @foreach($data['point_title'] as $index => $title)
                            <div>
                                <h3>{{ $title }}</h3>
                                <p>{{ $data['point_description'][$index] ?? '' }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

            <section class="d-flex align-items-center justify-content-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-10">
                            <div class="about-caption text-center p-4 rounded shadow" style="background-color: #ffffff;">
                                <h2 class="mb-3 fw-semibold" style="font-size: 32px;">
                                    Ready to Make an Impact?
                                </h2>
                                <p class="mb-4 text-muted" style="font-size: 16px;">
                                    Join our Ambassador Program and represent the future of learning!
                                </p>
                                <button type="button"
                                        class="btn btn-lg btn-primary shadow px-5 py-2"
                                        style="border-radius: 50px; font-weight: 500; font-size: 18px; transition: transform 0.3s ease-in-out;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#registrationModal"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'"
                                >
                                    🚀 Register Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ot-brand-area section-padding2">
                @if (!empty($data['ambassadors']))
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="section-tittle text-center mb-15">
                                    <h3 class="text-capitalize font-600">Latest Ambassadors</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="brand-wrapper brand-active swiper arrow-style">
                                    <div class="swiper-wrapper">
                                        @foreach ($data['ambassadors'] as $ambassador)
                                            <div class="swiper-slide mb-20 mt-24">
                                                <div class="ambassador-card text-center">
                                                    <div class="ambassador-img-box">
                                                        <img src="{{ showImage(@$ambassador->user->image_id, 'default-1.jpeg') }}" alt="img">
                                                        <p class="ambassador-role">Course Moderator<br>& Advisor</p>
                                                    </div>
                                                    <h5 class="ambassador-name">{{ @$ambassador->user->name }}</h5>
                                                    <p class="ambassador-designation">{{ @$ambassador?->university}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next swiper-btn">
                                        <i class="ri-arrow-right-line"></i>
                                    </div>
                                    <div class="swiper-button-prev swiper-btn">
                                        <i class="ri-arrow-left-line"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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

                              <form id="registrationForm" action="{{ route('ambassador.sign_up') }}" method="POST" enctype="multipart/form-data">
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
                                                    <input class="form-control" name="password" type="password" placeholder="*Enter Password " required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="facebook_id" placeholder="*Facebook profile" required>
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
                                                    <input type="text" class="form-control" name="linkedin_id" placeholder="*LinkedIn profile" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="instagram_id" placeholder="*Instagram profile" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="quora_id" placeholder="*Quora profile" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button id="nextBtn" class="btn btn-success" type="button">Next</button>
                                        </div>
                                    </div>

                                    <!-- Question Tab -->
                                    <div class="tab-pane fade" id="question" role="tabpanel">
                                        <div class="row">
                                            @if(is_array($data['questions']))
                                                @foreach($data['questions'] ?? [] as $index => $question)
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="questions[{{ $index }}][title]" value="{{ $question }}" required >
                                                        <textarea class="form-control mb-3" name="questions[{{ $index }}][answer]" required style="height: 80px;" placeholder="{{ $question }}"></textarea>
                                                    </div>
                                                @endforeach
                                            @endif
                                            </div>


                                        <div class="mb-3 mt-2">
                                            <label class="form-label">Upload resume</label>
                                            <input type="file" name="cv" class="form-control">
                                        </div>

                                        <div class="d-flex justify-content-center gap-3">
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
        // Handle Next button
        document.getElementById('nextBtn').addEventListener('click', function () {
            document.querySelectorAll('.text-danger.validation-error').forEach(el => el.remove());

            let isValid = true;
            const requiredFields = document.querySelectorAll('#basic input[required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;

                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'text-danger validation-error';
                    errorMessage.innerText = field.placeholder.replace("*", "") + ' is required.';

                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('validation-error')) {
                        field.parentNode.appendChild(errorMessage);
                    }
                }
            });

            if (isValid) {
                let tabTrigger = new bootstrap.Tab(document.querySelector('#question-tab'));
                tabTrigger.show();
            }
        });

        // Prevent form submission if required fields are empty
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            let isValid = true;
            document.querySelectorAll('.text-danger.validation-error').forEach(el => el.remove());

            const allRequiredFields = document.querySelectorAll('#registrationForm input[required], #registrationForm textarea[required]');

            allRequiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;

                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'text-danger validation-error';
                    errorMessage.innerText = field.placeholder.replace("*", "") + ' is required.';

                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('validation-error')) {
                        field.parentNode.appendChild(errorMessage);
                    }
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission
            }
        });
    </script>

@endsection
@section('scripts')
    <script>
        document.getElementById('previousBtn').addEventListener('click', function () {
            let tabTrigger = new bootstrap.Tab(document.querySelector('#basic-tab'));
            tabTrigger.show();
        });

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

