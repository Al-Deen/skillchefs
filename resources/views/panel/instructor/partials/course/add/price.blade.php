<div class="step-wrapper-contents">

    <!-- Step 3 -->
    <div class="step-2">
        <!-- Title -->
        <div class="setp-page-title mb-20">
            <h4 class="title font-600">
                <i class="ri-money-dollar-circle-line"></i>{{ ___('instructor.Course Price') }}
            </h4>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <!-- Check Box -->
                <div class="remember-checkbox mb-24">
                    <label>
                        <input class="ot-checkbox" type="checkbox" value="1" id="is_free"
                            {{ old('is_free') ? 'checked' : '' }} name="is_free" />
                        <small class="text-tertiary">{{ ___('label.Is it free course') }}</small>
                        <span class="ot-checkmark"></span>
                    </label>
                </div>
            </div>

            <div class="col-lg-12 price_div">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Course Price') }}</label>
                    <input class="ot-contact-input" type="nuber" name="price" id="price"
                        placeholder="{{ ___('placeholder.Enter Price') }}">
                </div>
            </div>

            <div class="col-lg-12 price_div">
                <!-- Check Box -->
                <div class="remember-checkbox mb-24">
                    <label>
                        <input class="ot-checkbox" type="checkbox" value="1" id="is_discount"
                            {{ old('is_discount') ? 'checked' : '' }} name="is_discount" />
                        <small class="text-tertiary">{{ ___('label.Check discount price') }}</small>
                        <span class="ot-checkmark"></span>
                    </label>
                </div>
            </div>
            <div class="col-lg-12 discount_div d-none">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Course Discount') }} </label>
                    <input class="ot-contact-input" type="nuber" name="discount_price" id="discount_price"
                        min="0" placeholder="{{ ___('placeholder.Enter Discount') }}">
                </div>
            </div>

            <div class="col-lg-12 discount_div d-none">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Discount Type') }} </label>
                    <select class="form-control ot-contact-input select2" name="discount_type" list="datalistOptions"
                        id="discount_type" placeholder="{{ ___('placeholder.Enter Discount Type') }}">
                        <option value="1">
                            {{ ___('course.Fixed') }}</option>
                        <option value="2">
                            {{ ___('course.Percentage') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</div>
