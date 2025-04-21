<div class="modal fade lead-modal" id="lead-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header modal-header-image mb-3">
                <h5 class="modal-title">{{ @$data['title'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="course_id" value="{{ @$data['section']->course_id }}">


                    <div class="row">
                        <!-- start title -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="title" class="form-label ">
                                {{ ___('course.Title') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="text" class="form-control ot-input" id="title" name="title"
                                placeholder="{{ ___('course.Title') }}" value="{{ old('title') }}" required />
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end title -->
                        <!-- start video duration -->
                        <div class="col-xl-12 col-md-12 mb-3 video_duration">
                            <label for="duration" class="form-label ">{{ ___('course.Duration') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="text" class="form-control ot-input" id="duration" name="duration" required
                                placeholder="20:10:20" value="{{ old('duration') }}" />
                            @error('duration')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end video duration -->
                        <!-- start marks -->
                        <div class="col-xl-12 col-md-12 mb-3 ">
                            <label for="marks" class="form-label ">{{ ___('course.Marks') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="number" class="form-control ot-input" id="marks" name="marks" required
                                placeholder="EX:20" value="{{ old('marks') }}" />
                            @error('marks')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end marks -->

                        <!-- start content -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="instruction" class="form-label ">{{ ___('course.Instruction') }}</label>
                            <textarea class="form-control ot-input ckeditor-editor" id="instruction" name="instruction" placeholder="{{ ___('course.instruction') }}">{{ old('instruction') }}</textarea>
                            @error('instruction')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end content -->

                        <div class="form-group d-flex justify-content-end mt-2">
                            <button type="button" onclick="submitForm()"
                                class="btn btn-lg ot-btn-primary">{{ @$data['button'] }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
