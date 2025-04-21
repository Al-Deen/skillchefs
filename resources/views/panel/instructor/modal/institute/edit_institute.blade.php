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
                            <label class="ot-contact-label">{{ ___('instructor.Institute') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="ot-contact-input" type="text" name="name" id="name"
                                value="{{ @$data['institute']['name'] }}"
                                placeholder="{{ ___('instructor.Daffodil International University') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Program') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="program" id="program"
                                value="{{ @$data['institute']['program'] }}"
                                placeholder="{{ ___('placeholder.Ex: Computer Science and Engineering') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Degree') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="degree" id="degree"
                                value="{{ @$data['institute']['degree'] }}"
                                placeholder="{{ ___('placeholder.Ex: Bachelor') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Start Date') }}
                                <span class="text-danger">*</span></label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="start_date"
                                id="start_date" value="{{ @$data['institute']['start_date'] }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-30">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" name="current"
                                        {{ @$data['institute']['current'] ? 'checked' : '' }} id="current">
                                    <small class="text-tertiary">{{ ___('instructor.Currently studying here') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div
                            class="ot-contact-form mb-24 end_date_div {{ @$data['institute']['current'] ? 'd-none' : '' }}">
                            <label class="ot-contact-label">{{ ___('instructor.End Date') }}</label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="end_date" value="{{ @$data['institute']['end_date'] }}"
                                id="end_date" {{ @$data['institute']['current'] ? 'disabled' : '' }}
                                placeholder="{{ ___('instructor.Start Date') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Description') }}</label>
                            <textarea class="ot-contact-textarea" name="description" id="description" cols="20" rows="5" placeholder=""><?= @$data['institute']['description'] ?></textarea>
                        </div>
                        <!-- Submit button -->
                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-fill" type="button"
                                onclick="submitMainForm()">{{ @$data['button'] }}</button>
                            <button class="btn-primary-outline close-modal"
                                type="button">{{ ___('instructor.Discard') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/instructor/__modal.min.js') }}"></script>
