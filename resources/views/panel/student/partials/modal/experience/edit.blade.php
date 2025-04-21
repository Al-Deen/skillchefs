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
                            <label class="ot-contact-label">{{ ___('student.Title') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input class="ot-contact-input" type="text" name="title" id="title" value="{{ @$data['experience']['title'] }}"
                                placeholder="{{ ___('student.EX: Senior Software Engineer') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Employment type') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select class="ot-contact modal_select2" name="employee_type" id="employee_type">
                                <option value="full_time" {{ @$data['experience']['employee_type'] == 'full_time' ? 'selected' : '' }}  >{{ ___('student.Full Time') }}</option>
                                <option value="part_time" {{ @$data['experience']['employee_type'] == 'part_time' ? 'selected' : '' }}  >{{ ___('student.Part Time') }}</option>
                                <option value="internship" {{ @$data['experience']['employee_type'] == 'internship' ? 'selected' : '' }}  >{{ ___('student.Internship') }}</option>
                                <option value="volunteer" {{ @$data['experience']['employee_type'] == 'volunteer' ? 'selected' : '' }}  >{{ ___('student.Volunteer') }}</option>
                                <option value="contract" {{ @$data['experience']['employee_type'] == 'contract' ? 'selected' : '' }}  >{{ ___('student.Contract') }}</option>
                                <option value="temporary" {{ @$data['experience']['employee_type'] == 'temporary' ? 'selected' : '' }}  >{{ ___('student.Temporary') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Company Name') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="name" id="name" value="{{ @$data['experience']['name'] }}"
                                placeholder="{{ ___('student.EX: Microsoft') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Location') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="location" id="location" value="{{ @$data['experience']['location'] }}"
                                placeholder="{{ ___('student.EX: California, United State') }}">
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Location Type') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" name="location_type" id="location_type">
                                <option value="onsite" {{ @$data['experience']['location_type'] == 'onsite' ? 'selected' : '' }}>{{ ___('student.On-site') }}</option>
                                <option value="hybrid" {{ @$data['experience']['location_type'] == 'hybrid' ? 'selected' : '' }}>{{ ___('student.Hybrid') }}</option>
                                <option value="remote" {{ @$data['experience']['location_type'] == 'remote' ? 'selected' : '' }}>{{ ___('student.Remote') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Start Date') }}
                                <span class="text-danger">*</span></label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="start_date" id="start_date" value="{{ @$data['experience']['start_date'] }}" >
                        </div>
                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-30">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" name="current" id="current" {{ @$data['experience']['current'] ? 'checked' : '' }} >
                                    <small class="text-tertiary">{{ ___('student.I am currently working in this role') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="ot-contact-form mb-24 end_date_div {{ @$data['experience']['current'] ? 'd-none' : '' }}">
                            <label class="ot-contact-label">{{ ___('student.End Date') }}</label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="end_date" value="{{ @$data['experience']['end_date'] }}"
                                id="end_date" placeholder="{{ ___('student.Start Date') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Description') }}</label>
                            <textarea class="ot-contact-textarea" name="description" id="description" cols="20" rows="5" placeholder=""><?= @$data['experience']['description'] ?></textarea>
                        </div>
                        <!-- Submit button -->
                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-fill" type="button"
                                onclick="submitMainForm()">{{ @$data['button'] }}</button>
                            <button class="btn-primary-outline close-modal"
                                type="button">{{ ___('student.Discard') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/student/__modal.min.js') }}"></script>
