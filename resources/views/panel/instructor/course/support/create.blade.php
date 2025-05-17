@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- instructor Create new Course -->
    <section class="create-new-course">
        <!-- MultiStep S t a r t-->
        <div class="row">
            <div class="col-lg-12">
                <!-- Next - Previus -->
                <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20 pb-20">
                    <!-- Section Tittle -->
                    <div class="section-tittle-two">
                        <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- MultiStep End -->
        <form action="{{ route('instructor.support.store', $data['course']->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- start general info -->
            <div class="step-wrapper-contents active">
                <div class="row">
                    <!-- Course Title -->
                    <div class="col-lg-12">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">Meeting Link<span class="text-danger">*</span>  </label>
                            <input class="form-control ot-contact-input" type="text" name="support_link" id="support_link"
                                   value="{{ old('support_link') }}" placeholder="Book Title" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex aling-items-center flex-wrap gap-10 mb-20">
                <button class="btn-primary-fill" type="submit"> Save </button>
            </div>
        </form>
    </section>
    <!-- End-of Create new Course -->

    <!-- Modal Custom -->

@endsection
@section('scripts')
    <script src="{{ url('frontend/js/instructor/__course.js') }}"></script>
@endsection
