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
                            <label for="title" class="ot-contact-label">{{ ___('event.Event Title') }}</label>
                            <p>
                                {{ @$data['event_registration']->event->title }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="date" class="ot-contact-label">{{ ___('event.Date') }}</label>
                            <p>
                                {{ showDate(@$data['event_registration']->created_at) }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="price" class="ot-contact-label">{{ ___('event.Price') }}</label>
                            <p>
                                {{ showPrice(@$data['event_registration']->price) }}
                            </p>
                        </div>
                        <div class="ot-contact-form mb-24 col-lg-6">
                            <label for="payment_method" class="ot-contact-label">{{ ___('event.Payment Method') }}</label>
                            <p>
                                {{ @$data['event_registration']->payment_method }}
                            </p>
                        </div>
                        <div class="row">
                            @if(@$data['event_registration']->event->event_type == 'Online')
                            <div class="small-tittle-two border-bottom mb-10 pb-8">
                                <h4 class="title text-capitalize font-600"><i class="ri-live-line action-success"></i> {{ ___('event.Online') }}</h4>
                            </div>
                            <div class="ot-contact-form mb-24 col-lg-6">
                                <label for="title" class="ot-contact-label">{{ ___('event.Online Media') }}</label>
                                <p>
                                    {{ @$data['event_registration']->event->online_media }}
                                </p>
                            </div>
                            <div class="ot-contact-form mb-24 col-lg-6">
                                <label for="title" class="ot-contact-label">{{ ___('event.Online Link') }}</label>
                                <p>
                                    <a href="{{ @$data['event_registration']->event->online_link }}" target="_blank">{{ @$data['event_registration']->event->online_link }}</a>
                                </p>
                            </div>
                            <div class="ot-contact-form mb-24 col-lg-6">
                                <label for="title" class="ot-contact-label">{{ ___('event.Online Note') }}</label>
                                <p>
                                    {{ @$data['event_registration']->event->online_note }}
                                </p>
                            </div>
                            <div class="ot-contact-form mb-24 col-lg-6">
                                <label for="title" class="ot-contact-label">{{ ___('event.Welcome Media') }}</label>
                                <p>
                                    {{ @$data['event_registration']->event->online_welcome_media }}
                                </p>
                            </div>
                            @else
                            <div class="small-tittle-two border-bottom mb-10 pb-8">
                                <h4 class="title text-capitalize font-600"><i class="ri-home-3-line action-success"></i> {{ ___('event.Offline') }}</h4>
                            </div>
                            <div class="ot-contact-form mb-24 col-lg-12">
                                <label for="title" class="ot-contact-label">{{ ___('event.Event Address') }}</label>
                                <p>
                                    {{ @$data['event_registration']->event->address }}
                                </p>
                            </div>
                            @endif
                        </div>
                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-outline close-modal"
                                type="button">{{ ___('event.Discard') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/instructor/__modal.min.js') }}"></script>
