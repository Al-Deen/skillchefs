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
                            <label for="name" class="ot-contact-label">{{ ___('event.Speaker Name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="name" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label for="designation" class="ot-contact-label">{{ ___('event.Designation') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="designation" name="designation" value="{{ old('designation') }}" />
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label for="image" class="ot-contact-label">{{ ___('event.Profile Image') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="ot-contact-input" id="image" name="image" value="{{ old('image') }}" />

                            <div
                                data-name="profile_image" class="file @error('profile_image') is-invalid @enderror"
                                data-height="200px ">
                            </div>
                            <small class="text-muted">
                                {{ ___('placeholder.NB : Image size will 100px x 100px and not more than 1mb') }}
                            </small>
                        </div>

                        <div class="ot-contact-form mb-24 ">
                            <label class="ot-contact-label">{{ ___('event.Status') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" required id="status_id" name="status_id">
                                <option value="1">{{ ___('common.Active') }}</option>
                                <option value="2">{{ ___('common.Inactive') }}</option>
                            </select>
                        </div>

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
