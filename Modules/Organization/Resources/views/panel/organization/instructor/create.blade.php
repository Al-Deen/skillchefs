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
                            <label for="name" class="ot-contact-label">{{ ___('instructor.Name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="name" name="name" value="{{ old('name') }}" placeholder="{{ ___('placeholder.Enter_Name') }}" />
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label for="email" class="ot-contact-label">{{ ___('instructor.Email') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="ot-contact-input" id="email" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="{{ ___('placeholder.Enter_Email') }}"/>
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label for="phone" class="ot-contact-label">{{ ___('instructor.Phone Number') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ ___('placeholder.Enter_Phone_Number') }}" />
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label for="password" class="ot-contact-label">{{ ___('instructor.Password') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="ot-contact-input" id="password" name="password" autocomplete="off" placeholder="{{ ___('placeholder.Enter_Your_Password') }}"/>
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
