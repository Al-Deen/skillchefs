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
                <form action="{{ @$data['url'] }}" method="post" id="modal_values" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- start title -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="question_title" class="form-label ">
                                {{ ___('course.Title') }}
                                <span class="fillable">*</span>
                            </label>
                            <input type="text" class="form-control ot-input" id="question_title"
                                name="question_title" placeholder="{{ ___('course.Title') }}"
                                value="{{ @$data['question']->title }}" required />
                        </div>
                        <!-- end title -->

                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="lesson_type" class="form-label ">
                                {{ ___('course.Question type') }}
                                <span class="fillable">*</span>
                            </label>
                            <select class="form-select ot-input modal_select2 change_question_type" id="type"
                                name="type" required>
                                <option value="0" {{ $data['question']->type == 0 ? 'selected' : '' }} >{{ ___('common.Single Question') }}</option>
                                <option value="1" {{ $data['question']->type == 1 ? 'selected' : '' }}>{{ ___('common.Multiple Question') }}</option>
                            </select>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="question_title" class="form-label ">
                                {{ ___('label.Number of options') }}
                                <span class="fillable">*</span>
                            </label>
                            <input type="number" class="form-control ot-input option_questions" id="total_options"
                                name="total_options" placeholder="{{ ___('label.Number of options') }}"
                                value="{{ @$data['question']->total_options }}" required />



                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
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
                        </div>


                    </div>

                    <div class="form-group d-flex justify-content-end">
                        <button type="button"
                            class="btn btn-lg ot-btn-primary submit_form_btn">{{ @$data['button'] }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
