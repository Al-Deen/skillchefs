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
                            <input class="ot-contact-input" type="text" name="question_title" id="question_title"
                                placeholder="{{ ___('instructor.title') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">
                                {{ ___('course.Question type') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <select class="ot-contact modal_select2 change_question_type" id="type" name="type">
                                <option value="0">{{ ___('common.Single Question') }}</option>
                                <option value="1">{{ ___('common.Multiple Question') }}</option>
                            </select>
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('label.Number of options') }}</label>
                            <input class="ot-contact-input option_questions" type="number" name="total_options"
                                id="total_options" placeholder="{{ ___('label.Number of options') }}">
                        </div>
                        <span class="options_div"></span>
                        <span id="answers"></span>
                        <span class="answers_div"></span>
                       
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
