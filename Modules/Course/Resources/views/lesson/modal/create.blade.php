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
                                <span class="fillable">*</span>
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
                        <!-- start lesson type -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="lesson_type" class="form-label ">
                                {{ ___('course.Lesson Type') }}
                                <span class="fillable">*</span>
                            </label>
                            <select class="form-select ot-input modal_select2" id="lesson_type" name="lesson_type" required onchange="lessonType(this)">
                                @foreach (\App\Enums\LessonEnum::getValues() as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ old('lesson_type') == $key ? 'selected' : '' }}>
                                        {{ $key }}</option>
                                @endforeach
                            </select>
                            @error('lesson_type')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- start video_url -->
                        <!-- start video_url -->
                        <div class="col-xl-12 col-md-12 mb-3 video_url">
                            <label for="video_url" class="form-label ">{{ ___('course.Video URL') }}
                                <span class="fillable">*</span>
                            </label>
                            <input type="text" class="form-control ot-input" id="video_url" name="video_url" required
                                placeholder="{{ ___('course.video_url') }}" value="{{ old('video_url') }}" />
                            @error('video_url')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end video_url -->
                        <!-- start video duration -->
                        <div class="col-xl-12 col-md-12 mb-3 video_duration">
                            <label for="duration" class="form-label ">{{ ___('course.Duration') }}
                                <span class="fillable">*</span>
                            </label>
                            <input type="number" class="form-control ot-input" min="0" id="duration" name="duration" required
                                placeholder="20:10:20" value="{{ old('duration') }}" />
                            @error('duration')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end video duration -->
                        <!-- start video_file -->
                        <div class="col-xl-12 col-md-12 mb-3 video_file d-none">

                            <label for="details" class="form-label ">{{ ___('course.Video File') }}</label>

                            <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                <input class="form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Video File') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="video_file">{{ ___('common.Browse') }}
                                    <input type="file" class="d-none form-control" name="video_file" id="video_file" accept=".mp4,.webm">
                                </button>
                            </div>
                            <small class="text-primary">{{ ___('course.Video file must be less than 5MB') }}</small><br>
                            <div class="invalid-feedback d-inline error-video_file"></div>
                            @error('video_file')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end video_file -->
                        <!-- start document_file type -->
                        <div class="col-xl-12 col-md-12 mb-3 document_file_type d-none">
                            <label for="document_file_type" class="form-label ">
                                {{ ___('course.Document Type') }}
                                <span class="fillable">*</span>
                            </label>
                            <select class="form-select ot-input modal_select2" id="document_file_type" name="document_file_type" required>
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
                        <div class="col-xl-12 col-md-12 mb-3 document_file d-none">

                            <label for="details" class="form-label ">{{ ___('course.Attachment File') }}</label>

                            <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                <input class="form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Attachment File') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="attachment">{{ ___('common.Browse') }}
                                    <input type="file" class="d-none form-control" name="attachment"
                                        accept=".pdf,.doc,.docx" id="attachment">
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
                         <div class="col-xl-12 col-md-12 mb-3 image_file d-none">

                            <label for="Image" class="form-label ">{{ ___('course.Image File') }}</label>

                            <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                <input class="form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Image File') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="image_file">{{ ___('common.Browse') }}
                                    <input type="file" class="d-none form-control" name="image_file"
                                        accept=".png, .jpg, .jpeg" id="image_file">
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
                        <div class="col-xl-12 col-md-12 mb-3 iframe_source d-none">
                            <label for="iframe" class="form-label ">{{ ___('course.Iframe Source') }}</label>
                            <textarea class="form-control ot-input" id="iframe" name="iframe" placeholder="{{ ___('course.iframe') }}">{{ old('iframe') }}</textarea>
                            @error('iframe')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end iframe source -->

                        <!-- start text -->
                        <div class="col-xl-12 col-md-12 mb-3 text_key d-none">
                            <label for="lesson_text" class="form-label ">{{ ___('course.Text') }}</label>
                            <textarea class="form-control ot-input ckeditor-editor" id="lesson_text" name="lesson_text" placeholder="{{ ___('course.text') }}">{{ old('lesson_text') }}</textarea>
                            @error('lesson_text')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end text -->
                        <!-- start content -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="content" class="form-label ">{{ ___('course.Content') }}</label>
                            <textarea class="form-control ot-input ckeditor-editor" id="content" name="content" placeholder="{{ ___('course.Content') }}">{{ old('content') }}</textarea>
                            @error('content')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- end content -->

                        <!-- start is_free -->
                        <div class="col-xl-12 col-md-6 mb-3 d-flex">
                            <div class="input-check-radio">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="1" id="is_free"
                                        {{ old('is_free') ? 'checked' : '' }}
                                        name="is_free">
                                    <label class="form-check-label"
                                        for="is_free">{{ ___('course.Is it free course') }}
                                </div>
                            </div>
                        </div>
                        <!-- end is_free -->

                    </div>

                    <div class="form-group d-flex justify-content-end">
                        <button type="button" onclick="submitForm()"
                            class="btn btn-lg ot-btn-primary">{{ @$data['button'] }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
