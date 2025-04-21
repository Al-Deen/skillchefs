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
                                value="{{ @$data['question']->title }}" placeholder="{{ ___('instructor.title') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">
                                {{ ___('course.Question type') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <select class="ot-contact modal_select2 change_question_type" id="type" name="type">
                                <option value="0" {{ $data['question']->type == 0 ? 'selected' : '' }}>
                                    {{ ___('common.Single Question') }}</option>
                                <option value="1" {{ $data['question']->type == 1 ? 'selected' : '' }}>
                                    {{ ___('common.Multiple Question') }}</option>
                            </select>
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('label.Number of options') }}</label>
                            <input class="ot-contact-input option_questions" type="number" name="total_options"
                                value="{{ @$data['question']->total_options }}" id="total_options"
                                placeholder="{{ ___('label.Number of options') }}">
                        </div>
                        <span class="options_div">
                            @if (@$data['question']->options)
                                @foreach (json_decode($data['question']->options) as $key => $option)
                                    <div class="ot-contact-form mb-24">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="{{ $data['question']->type == 1 ? 'checkbox' : 'radio' }}" class="form-check-input"
                                                        name="answers[]" value="{{ $key }}"
                                                        {{ @$data['question']->answer && in_array($option, json_decode(@$data['question']->answer)) ? 'checked' : '' }}
                                                        >
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="options[]"
                                                value="{{ @$option }}"
                                                placeholder="{{ ___('label.Option') }}">
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                        </span>

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
