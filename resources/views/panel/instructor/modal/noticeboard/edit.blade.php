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
                            <input class="ot-contact-input" type="text" name="notice_title" id="notice_title"
                                value="{{ @$data['noticeboard']->title }}" placeholder="{{ ___('instructor.title') }}">
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('label.Description') }}</label>
                            <textarea class="form-control ot-textarea" id="notice_description" name="notice_description" rows="5"
                                placeholder="{{ ___('course.Description') }}">{{ @$data['noticeboard']->description }}</textarea>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-24">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" value="1"
                                        @if (@$data['noticeboard']->is_send_mail == 1) checked @endif id="is_send_mail"
                                        name="is_send_mail" />
                                    <small class="text-tertiary">{{ ___('label.Notify To All Students') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <!-- Submit button -->
                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-fill submit_form_tab_modal"
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
