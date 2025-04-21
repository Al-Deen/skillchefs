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
                            <input class="ot-contact-input" type="text" name="title" id="title"
                                placeholder="{{ ___('instructor.EX: Senior Software Engineer') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Employment type') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select class="ot-contact modal_select2" name="employee_type" id="employee_type">
                                <option value="full_time">{{ ___('instructor.Full Time') }}</option>
                                <option value="part_time">{{ ___('instructor.Part Time') }}</option>
                                <option value="internship">{{ ___('instructor.Internship') }}</option>
                                <option value="volunteer">{{ ___('instructor.Volunteer') }}</option>
                                <option value="contract">{{ ___('instructor.Contract') }}</option>
                                <option value="temporary">{{ ___('instructor.Temporary') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Company Name') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="name" id="name"
                                placeholder="{{ ___('instructor.EX: Microsoft') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Location') }}<span
                                    class="text-danger">*</span></label>
                            <input class="ot-contact-input" type="text" name="location" id="location"
                                placeholder="{{ ___('instructor.EX: California, United State') }}">
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Location Type') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" name="location_type" id="location_type">
                                <option value="onsite">{{ ___('instructor.On-site') }}</option>
                                <option value="hybrid">{{ ___('instructor.Hybrid') }}</option>
                                <option value="remote">{{ ___('instructor.Remote') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Start Date') }}
                                <span class="text-danger">*</span></label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="start_date"
                                id="start_date">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-30">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" name="current" id="current">
                                    <small class="text-tertiary">{{ ___('instructor.I am currently working in this role') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="ot-contact-form mb-24 end_date_div">
                            <label class="ot-contact-label">{{ ___('instructor.End Date') }}</label>
                            <input class="form-control ot-contact-input datePicker" type="text" name="end_date"
                                id="end_date" placeholder="{{ ___('instructor.Start Date') }}">
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Description') }}</label>
                            <textarea class="ot-contact-textarea" name="description" id="description" cols="20" rows="5" placeholder=""> </textarea>
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
