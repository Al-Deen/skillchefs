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
                            <input class="ot-contact-input" type="text" name="title" id="title"
                                placeholder="{{ ___('student.EX: Senior Software Engineer') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Employment type') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select class="ot-contact modal_select2" name="employee_type" id="employee_type">
                                <option value="full_time">{{ ___('student.Full Time') }}</option>
                                <option value="part_time">{{ ___('student.Part Time') }}</option>
                                <option value="internship">{{ ___('student.Internship') }}</option>
                                <option value="volunteer">{{ ___('student.Volunteer') }}</option>
                                <option value="contract">{{ ___('student.Contract') }}</option>
                                <option value="temporary">{{ ___('student.Temporary') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Company Name') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="name" id="name"
                                placeholder="{{ ___('student.EX: Microsoft') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Location') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="location" id="location"
                                placeholder="{{ ___('student.EX: California, United State') }}">
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Location Type') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" name="location_type" id="location_type">
                                <option value="onsite">{{ ___('student.On-site') }}</option>
                                <option value="hybrid">{{ ___('student.Hybrid') }}</option>
                                <option value="remote">{{ ___('student.Remote') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Start Date') }}
                                <span class="text-danger">*</span></label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="start_date"
                                id="start_date">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-30">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" name="current" id="current">
                                    <small class="text-tertiary">{{ ___('student.I am currently working in this role') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="ot-contact-form mb-24 end_date_div">
                            <label class="ot-contact-label">{{ ___('student.End Date') }}</label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="end_date"
                                id="end_date" placeholder="{{ ___('student.Start Date') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('student.Description') }}</label>
                            <textarea class="ot-contact-textarea" name="description" id="description" cols="20" rows="5" placeholder=""> </textarea>
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
