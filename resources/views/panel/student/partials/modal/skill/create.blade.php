<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">

            <div class="modal-body">
                <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
                <div class="custom-modal-body ">
                    <form action="{{ @$data['url'] }}" method="post" id="modal_values" enctype="multipart/form-data" class="experiences">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <!-- add -->
                                <div class="settings-expertise-content">
                                    <div class="row justify-content-between">
                                        <div class="col-lg-12">
                                            <div class="ot-contact-form position-relative">
                                                <label class="ot-contact-label">{{ $data['title'] }}</label>
                                                <input class="tagify--outside border-0" type="text"
                                                    placeholder="{{ ___('student.add skills')}}" name="skills" id="skills"
                                                    value="{{ @$data['student']->skills ? json_encode(@$data['student']->skills) : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Button -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="btn-wrapper d-flex flex-wrap gap-10 mt-30">
                                    <button class="btn-primary-fill" type="button"
                                    onclick="submitMainForm()">{{ @$data['button'] }}</button>
                                <button class="btn-primary-outline close-modal"
                                    type="button">{{ ___('student.Discard') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/student/__modal.min.js') }}"></script>
