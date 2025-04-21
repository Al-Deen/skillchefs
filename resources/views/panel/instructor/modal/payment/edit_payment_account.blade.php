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
                            <label class="ot-contact-label">{{ ___('instructor.Status') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" required id="payment_method" name="payment_method">
                                @foreach ($data['payment_methods'] as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}"
                                        {{ $paymentMethod->id == @$data['payment_method']->payment_method_id ? ' selected' : '' }}>
                                        {{ ucfirst($paymentMethod->name) }} </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- start client_id -->
                        <div class="ot-contact-form mb-24 paypal_div d-none">
                            <label for="client_id" class="ot-contact-label">{{ ___('course.Client ID') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="client_id" name="client_id"
                                value="" autocomplete="off" />
                        </div>
                        <!-- end client_id -->
                        <!-- start secret -->
                        <div class="ot-contact-form mb-24 paypal_div d-none">
                            <label for="secret" class="ot-contact-label">{{ ___('course.Secret') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="secret" name="secret"
                                value="{{ old('secret') }}" autocomplete="off" />
                        </div>
                        <!-- end secret -->
                        <!-- start store_id -->
                        <div class="ot-contact-form mb-24 sslcommerz_div d-none">
                            <label for="store_id" class="ot-contact-label">{{ ___('course.Store ID') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="store_id" name="store_id"
                                value="{{ @$data['payment_method']->credentials['SSLCZ_STORE_ID'] }}"
                                autocomplete="off" />
                        </div>
                        <!-- end store_id -->
                        <!-- start store_password -->
                        <div class="ot-contact-form mb-24 sslcommerz_div d-none">
                            <label for="store_password" class="ot-contact-label">{{ ___('course.Store Password') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="store_password" name="store_password"
                                value="{{ @$data['payment_method']->credentials['SSLCZ_STORE_PASSWD'] }}"
                                autocomplete="off" />
                        </div>
                        <!-- end store_password -->
                        <!-- start key -->
                        <div class="ot-contact-form mb-24 stripe_div">
                            <label for="stripe_key" class="ot-contact-label">{{ ___('course.Key') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="stripe_key" name="stripe_key"
                                value="{{ @$data['payment_method']->credentials['STRIPE_KEY'] }}" autocomplete="off" />
                        </div>
                        <!-- end key -->
                        <!-- start stripe_secret -->
                        <div class="ot-contact-form mb-24 stripe_div">
                            <label for="stripe_secret" class="ot-contact-label">{{ ___('course.Secret') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="ot-contact-input" id="stripe_secret" name="stripe_secret"
                                value="{{ @$data['payment_method']->credentials['STRIPE_SECRET'] }}"
                                autocomplete="off" />
                        </div>
                        <!-- end stripe_secret -->

                        <div class="ot-contact-form mb-24">
                            <label for="password" class="ot-contact-label">{{ ___('course.Password') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="ot-contact-input" id="password" name="password"
                                autocomplete="off" />
                        </div>



                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('common.Type') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" required id="type" name="type">
                                <option value="1" {{ @$data['payment_method']->type == 1 ? ' selected' : '' }}>
                                    {{ ___('common.Test') }}</option>
                                <option value="2" {{ @$data['payment_method']->type == 2 ? ' selected' : '' }}>
                                    {{ ___('common.Live') }}</option>
                            </select>
                        </div>
                        <div class="ot-contact-form mb-24 ">
                            <label class="ot-contact-label">{{ ___('instructor.Status') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" required id="status_id" name="status_id">
                                <option value="1"
                                    {{ $data['payment_method']->status_id == 1 ? ' selected' : '' }}>
                                    {{ ___('common.Active') }}</option>
                                <option value="2"
                                    {{ $data['payment_method']->status_id == 2 ? ' selected' : '' }}>
                                    {{ ___('common.Inactive') }}</option>
                            </select>
                        </div>

                        <div class="ot-contact-form mb-24">
                            <div class="remember-checkbox mb-24">
                                <label>
                                    <input class="ot-checkbox" type="checkbox" value="1" id="is_default" name="is_default"
                                        {{ $data['payment_method']->is_default == 1 ? ' checked' : '' }}
                                     />
                                    <small class="text-tertiary">{{ ___('label.Default') }}</small>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </div>
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
