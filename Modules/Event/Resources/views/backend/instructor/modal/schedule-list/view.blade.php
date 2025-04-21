<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">

            <div class="modal-body">
                <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
                <div class="custom-modal-body ">
                    <div id="modal_values" class="row">
                        <!-- Title -->
                        <div class="small-tittle-two border-bottom mb-30 pb-8">
                            <h4 class="title text-capitalize font-600">{{ $data['title'] }} </h4>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="marks" class="ot-contact-label">{{ ___('event.Title') }}</label>
                            <p>
                                {{ @$data['schedule-list']->title }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="marks" class="ot-contact-label">{{ ___('event.Deatsils') }}</label>
                            <p>
                                {{ @$data['schedule-list']->details }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="note" class="ot-contact-label">{{ ___('event.Start Time') }}</label>
                            <p>
                                {{ showTime(@$data['schedule-list']->from_time) }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="note" class="ot-contact-label">{{ ___('event.End Time') }}</label>
                            <p>
                                {{ showTime(@$data['schedule-list']->to_time) }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="marks" class="ot-contact-label">{{ ___('event.Location') }}
                            </label>
                            <p>
                                {{ @$data['schedule-list']->location }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label class="ot-contact-label">{{ ___('instructor.Status') }}</label>
                            <p>
                                <span class="badge {{ 'badge-' . @$data['schedule-list']->status->class }}">{{ @$data['schedule-list']->status->name }}</span>
                            </p>
                        </div>
                        <!-- Submit button -->
                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-outline close-modal"
                                type="button">{{ ___('student.Discard') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/instructor/__modal.min.js') }}"></script>
