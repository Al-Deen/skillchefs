<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true">
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
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Title') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="ot-contact-input" type="text" name="assignment_title" id="assignment_title"
                                placeholder="{{ ___('course.Title') }}">
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label for="details" class="ot-contact-label">{{ ___('course.Details') }}</label>
                            <textarea class="ot-contact-input ckeditor-editor" id="details" name="details"
                                placeholder="{{ ___('course.Details') }}">{{ old('details') }}</textarea>
                        </div>

                        <!-- start marks -->
                        <div class="ot-contact-form mb-24">
                            <label for="marks" class="ot-contact-label">{{ ___('course.Marks') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="number" class="ot-contact-input" id="marks" name="marks"
                                placeholder="EX:60" value="{{ old('marks') }}" autocomplete="off" />
                        </div>
                        <!-- end marks -->

                        <!-- start pass marks -->
                        <div class="ot-contact-form mb-24">
                            <label for="pass_marks" class="ot-contact-label">{{ ___('course.Pass Marks') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="number" class="ot-contact-input" id="pass_marks" name="pass_marks"
                                placeholder="EX:20" value="{{ old('pass_marks') }}" autocomplete="off" />
                        </div>
                        <!-- end pass marks -->

                        <!-- start document_file -->
                        <div class="ot-contact-form mb-24">

                            <label for="details" class="ot-contact-label">{{ ___('course.Assignment File') }}</label>
                            <div class="ot_fileUploader left-side mb-2">
                                <input class="form-control form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Assignment File') }}" id="placeholder">
                                <button class="border-0" type="button">
                                    <label class="btn-uplode" for="assignment_file">{{ ___('common.Browse') }}</label>
                                    <input type="file" class="d-none form-control" name="assignment_file"
                                        id="assignment_file" accept=".pdf,.doc,.docx">
                                </button>
                            </div>
                            <div class="invalid-feedback d-inline error-assignment_file"></div>
                        </div>
                        <!-- end document_file -->

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('course.Deadline') }}<span
                                    class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control ot-input" id="deadline" name="deadline"
                                required placeholder="{{ ___('course.Deadline') }}" value="{{ old('deadline') }}" />
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label for="note" class="ot-contact-label">{{ ___('course.Note') }}</label>
                            <textarea class="form-control ot-input" id="note" name="note" placeholder="{{ ___('course.note') }}">{{ old('note') }}</textarea>
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Status') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" required id="status_id" name="status_id">
                                @foreach (assignmentType() as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-24">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" value="1" id="is_notify"
                                        name="is_notify" />
                                    <small class="text-tertiary">{{ ___('label.Notify To All Students') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>
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
