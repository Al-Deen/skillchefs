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
                        <div class="col-xl-12">
                            <!-- add -->
                            <div class="settings-expertise-content">
                                <div class="row justify-content-between">
                                    <div class="col-lg-12">
                                        <div class="ot-contact-form position-relative">
                                            <label class="ot-contact-label">{{ $data['title'] }}</label>
                                            <input class="tagify--outside border-0" type="text" placeholder="{{ ___('student.add skills')}}"
                                                name="skills" id="skills"
                                                value="{{ @$data['student']->skills ? json_encode(@$data['student']->skills) : '' }}">
                                        </div>
                                    </div>
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
