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

                    <div class="row mb-3 p-2 mb-3 d-flex justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-xl-12 mb-3">
                                    <label for="title" class="form-label ">
                                        {{ ___('instructor.Title') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input" type="text" name="title" id="title"
                                        value="{{ @$data['experience']['title'] }}"
                                        placeholder="{{ ___('instructor.EX: Senior Software Engineer') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="program" class="form-label ">
                                        {{ ___('instructor.Employment type') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <select class="ot-contact modal_select2" name="employee_type" id="employee_type">
                                        <option value="full_time"
                                            {{ @$data['experience']['employee_type'] == 'full_time' ? 'selected' : '' }}>
                                            {{ ___('instructor.Full Time') }}</option>
                                        <option value="part_time"
                                            {{ @$data['experience']['employee_type'] == 'part_time' ? 'selected' : '' }}>
                                            {{ ___('instructor.Part Time') }}</option>
                                        <option value="internship"
                                            {{ @$data['experience']['employee_type'] == 'internship' ? 'selected' : '' }}>
                                            {{ ___('instructor.Internship') }}</option>
                                        <option value="volunteer"
                                            {{ @$data['experience']['employee_type'] == 'volunteer' ? 'selected' : '' }}>
                                            {{ ___('instructor.Volunteer') }}</option>
                                        <option value="contract"
                                            {{ @$data['experience']['employee_type'] == 'contract' ? 'selected' : '' }}>
                                            {{ ___('instructor.Contract') }}</option>
                                        <option value="temporary"
                                            {{ @$data['experience']['employee_type'] == 'temporary' ? 'selected' : '' }}>
                                            {{ ___('instructor.Temporary') }}</option>
                                    </select>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="program" class="form-label ">
                                        {{ ___('instructor.Company Name') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input" type="text" name="name" id="name"
                                        value="{{ @$data['experience']['name'] }}"
                                        placeholder="{{ ___('instructor.EX: Microsoft') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="program" class="form-label ">
                                        {{ ___('instructor.Location') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input" type="text" name="location" id="location"
                                        value="{{ @$data['experience']['location'] }}"
                                        placeholder="{{ ___('instructor.EX: California, United State') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="program" class="form-label ">
                                        {{ ___('instructor.Location Type') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <select class="ot-contact modal_select2" name="location_type" id="location_type">
                                        <option value="onsite"
                                            {{ @$data['experience']['location_type'] == 'onsite' ? 'selected' : '' }}>
                                            {{ ___('instructor.On-site') }}</option>
                                        <option value="hybrid"
                                            {{ @$data['experience']['location_type'] == 'hybrid' ? 'selected' : '' }}>
                                            {{ ___('instructor.Hybrid') }}</option>
                                        <option value="remote"
                                            {{ @$data['experience']['location_type'] == 'remote' ? 'selected' : '' }}>
                                            {{ ___('instructor.Remote') }}</option>
                                    </select>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="start_date" class="form-label ">
                                        {{ ___('instructor.Start Date') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('start_date') is-invalid @enderror"
                                        value="{{ date('Y-m-d', strtotime(@$data['experience']['start_date'])) }}"
                                        name="start_date" id="start_date" type="date">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            {{ @$data['experience']['current'] ? 'checked' : '' }} name="current"
                                            id="current">
                                        <label class="form-check-label"
                                            for="current">{{ ___('instructor.I am currently working in this role') }}</label>
                                    </div>
                                </div>


                                <div
                                    class="col-xl-12 mb-3 end_date_div {{ @$data['experience']['current'] ? 'd-none' : '' }}">
                                    <label for="end_date" class="form-label ">
                                        {{ ___('instructor.End Date') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('end_date') is-invalid @enderror"
                                        value="{{ date('Y-m-d', strtotime(@$data['experience']['end_date'])) }}"
                                        name="end_date" id="end_date" type="date">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="description" class="form-label ">
                                        {{ ___('instructor.Description') }}
                                    </label>
                                    <textarea class="ot-textarea form-control  @error('description') is-invalid @enderror" id="text" rows="6"
                                        placeholder="{{ ___('instructor.description') }}" name="description" id="" rows="10"><?= @$data['experience']['description'] ?></textarea>
                                </div>

                            </div>
                        </div>


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
