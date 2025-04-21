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
                                @foreach ($data['payment_methods'] as $payment)
                                    <option value="{{ $payment->id }}">
                                        {{ ucfirst($payment->paymentMethod->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- start amount -->
                        <div class="mb-24">
                            <div class="ot-contact-form">
                                <label for="marks" class="ot-contact-label">{{ ___('common.Amount') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="number" class="ot-contact-input" id="amount" name="amount"
                                    placeholder="EX:20" value="{{ old('amount') }}" autocomplete="off" />
                                {{-- // make hint --}}
                            </div>
                            <small
                                class="text-tertiary">{{ ___('payment.You can request a withdrawal for an amount equal to or less than') }}
                                <strong> {{ showPrice(@$data['instructor']->balance) }} </strong>
                            </small>
                        </div>

                        <!-- end amount -->
                        <div class="ot-contact-form mb-24">
                            <label for="note" class="ot-contact-label">{{ ___('course.Note') }}</label>
                            <textarea rows="5" class="form-control ot-input" id="note" name="note" placeholder="{{ ___('course.note') }}">{{ old('note') }}</textarea>
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
