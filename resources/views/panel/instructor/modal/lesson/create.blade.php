<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true" data-keyboard="false"
    data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">

            <div class="modal-body">
                <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
                <div class="custom-modal-body ">
                    <form action="{{ @$data['url'] }}" method="post" id="modal_values" enctype="multipart/form-data">
                        @csrf
                        <!-- Title -->
                        <div class="small-tittle-two border-bottom mb-30 pb-8">
                            <h4 class="title text-capitalize font-600">{{ $data['title'] }} </h4>
                        </div>
                        <!-- start title -->
                        <div class="ot-contact-form mb-24">
                            <label for="title" class="ot-contact-label">
                                {{ ___('course.Title') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="text" class="ot-contact-input" id="lesson_title" name="lesson_title"
                                placeholder="{{ ___('instructor.EX: How to install vscode') }}"
                                value="{{ old('title') }}" />
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end title -->
                        <div class="ot-contact-form mb-24">
                            <label for="is_quiz" class="ot-contact-label">
                                {{ ___('course.Quiz Or Lesson ?') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <select class="ot-contact modal_select2" id="is_quiz" name="is_quiz">
                                <option value="0">{{ ___('common.Lesson') }}</option>
                                <option value="1">{{ ___('common.Quiz') }}</option>
                            </select>
                        </div>

                        <!-- start lesson type -->
                        <div class="ot-contact-form mb-24 lesson_div">
                            <label for="lesson_type" class="ot-contact-label">
                                {{ ___('course.Lesson Type') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <select class="ot-contact modal_select2" id="lesson_type" name="lesson_type">
                                @foreach (\App\Enums\LessonEnum::getValues() as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ old('lesson_type') == $key ? 'selected' : '' }}>
                                        {{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- start video_url -->
                        <!-- start video_url -->
                        <div class="ot-contact-form mb-24 video_url lesson_div">
                            <label for="video_url" class="ot-contact-label">{{ ___('course.Video URL') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="text" class="ot-contact-input" id="lesson_video_url" name="lesson_video_url"
                                placeholder="{{ ___('course.video_url') }}" value="{{ old('video_url') }}" />
                            @error('video_url')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end video_url -->
                        <div class="ot-contact-form mb-24 quiz_div">
                            <div class="remember-checkbox mb-24">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" value="1" id="is_timer"
                                        name="is_timer" />
                                    <small class="text-tertiary">{{ ___('label.There is no time limit') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <!-- start video duration -->
                        <div class="mb-24 video_duration">
                            <div class="ot-contact-form ">
                                <label for="duration" class="ot-contact-label">{{ ___('course.Duration') }}
                                    <span class="text-danger">*</span></label>
                                </label>
                                <input type="number" class="ot-contact-input" min="0" id="duration" name="duration"
                                    placeholder="60" value="{{ old('duration') }}" />
                                @error('duration')
                                    <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-tertiary">{{ ___('instructor.NB: The time value must be in seconds.') }}
                            </small>
                        </div>
                        <!-- end video duration -->
                        <!-- start marks -->
                        <div class="ot-contact-form mb-24 d-none quiz_div">
                            <label for="marks" class="ot-contact-label">{{ ___('course.Marks') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="number" class="ot-contact-input" id="marks" name="marks"
                                placeholder="EX:60" value="{{ old('marks') }}" autocomplete="off" />
                        </div>
                        <!-- end marks -->
                        <!-- start pass marks -->
                        <div class="ot-contact-form mb-24 d-none quiz_div">
                            <label for="pass_marks" class="ot-contact-label">{{ ___('course.Pass Marks') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="number" class="ot-contact-input" id="pass_marks" name="pass_marks"
                                placeholder="EX:20" value="{{ old('pass_marks') }}" autocomplete="off" />
                        </div>
                        <!-- end pass marks -->
                        <!-- start video_file -->
                        <div class="ot-contact-form mb-24 video_file d-none lesson_div">

                            <label for="details" class="ot-contact-label">{{ ___('course.Video File') }}</label>
                            <div class="ot_fileUploader left-side mb-2">
                                <input class="form-control form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Video File') }}" id="placeholder">
                                <button class="border-0" type="button">
                                    <label class="btn-uplode" for="video_file">{{ ___('common.Browse') }}</label>
                                    <input type="file" class="d-none form-control" name="video_file"
                                        id="video_file" accept=".mp4,.webm">
                                </button>
                            </div>
                            <small
                                class="text-primary">{{ ___('course.Video file must be less than 5MB') }}</small><br>
                            <div class="invalid-feedback d-inline error-video_file"></div>
                            @error('video_file')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end video_file -->
                        <!-- start document_file type -->
                        <div class="ot-contact-form mb-24 document_file_type d-none lesson_div">
                            <label for="document_file_type" class="ot-contact-label">
                                {{ ___('course.Document Type') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <select class="ot-contact modal_select2" id="document_file_type"
                                name="document_file_type">
                                <option value="1">{{ ___('common.Pdf File') }}</option>
                                <option value="2">{{ ___('common.Doc File') }}</option>
                            </select>
                            @error('document_file_type')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end document_file type -->

                        <!-- start document_file -->
                        <div class="ot-contact-form mb-24 document_file d-none lesson_div">

                            <label for="details"
                                class="ot-contact-label">{{ ___('course.Attachment File') }}</label>
                            <div class="ot_fileUploader left-side mb-2">
                                <input class="form-control form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Attachment File') }}" id="placeholder">
                                <button class="border-0" type="button">
                                    <label class="btn-uplode" for="attachment">{{ ___('common.Browse') }}</label>
                                    <input type="file" class="d-none form-control" name="attachment"
                                        id="attachment" accept=".pdf,.doc,.docx">
                                </button>
                            </div>

                            <div class="invalid-feedback d-inline error-attachment"></div>
                            @error('attachment')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end document_file -->

                        <!-- start document_file -->
                        <div class="ot-contact-form mb-24 image_file d-none lesson_div">

                            <label for="Image" class="ot-contact-label">{{ ___('course.Image File') }}</label>

                            <div class="ot_fileUploader left-side mb-2">
                                <input class="form-control form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Image File') }}" id="placeholder">
                                <button class="border-0" type="button">
                                    <label class="btn-uplode" for="image_file">{{ ___('common.Browse') }}</label>
                                    <input type="file" class="d-none form-control" name="image_file"
                                        id="image_file" accept=".png, .jpg, .jpeg">
                                </button>
                            </div>
                            <div class="invalid-feedback d-inline error-image_file"></div>
                            @error('image_file')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end document_file -->

                        <!-- start iframe source -->
                        <div class="ot-contact-form mb-24 iframe_source d-none lesson_div">
                            <label for="iframe" class="ot-contact-label">{{ ___('course.Iframe Source') }}</label>
                            <textarea class="ot-contact-input" id="iframe" name="iframe" placeholder="{{ ___('course.iframe') }}">{{ old('iframe') }}</textarea>
                            @error('iframe')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end iframe source -->

                        <!-- start text -->
                        <div class="ot-contact-form mb-24 text_key d-none lesson_div">
                            <label for="lesson_text" class="ot-contact-label">{{ ___('course.Text') }}</label>
                            <textarea class="ot-contact-input ckeditor-editor" id="lesson_text" name="lesson_text"
                                placeholder="{{ ___('course.text') }}">{{ old('lesson_text') }}</textarea>
                            @error('lesson_text')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end text -->
                        <!-- start instruction -->
                        <div class="ot-contact-form mb-24 d-none quiz_div">
                            <label for="instruction" class="ot-contact-label">{{ ___('course.Instruction') }}</label>
                            <textarea class="ot-contact-input ckeditor-editor" id="instruction" name="instruction"
                                placeholder="{{ ___('course.Instruction') }}">{{ old('instruction') }}</textarea>
                        </div>
                        <!-- end instruction -->
                        <!-- start content -->
                        <div class="ot-contact-form mb-24 lesson_div">
                            <label for="content" class="ot-contact-label">{{ ___('course.Content') }}</label>
                            <textarea class="ot-contact-input ckeditor-editor" id="content" name="content"
                                placeholder="{{ ___('course.Content') }}">{{ old('content') }}</textarea>
                            @error('content')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end content -->

                        <!-- Submit button -->
                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-fill submit_form_btn"
                                type="button">{{ @$data['button'] }}</button>
                            <button class="btn-primary-outline close-modal"
                                type="button">{{ ___('student.Discard') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/instructor/__modal.min.js') }}"></script>
