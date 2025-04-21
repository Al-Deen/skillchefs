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

                        <input type="hidden" value="">
                        <!-- start title -->
                        <div class="mb-24">
                            <div class="ot-contact-form">
                                <label for="marks" class="ot-contact-label">{{ ___('event.Title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="ot-contact-input" id="title" name="title"
                                    placeholder="First Day" value="{{ old('title') }}" autocomplete="off" />
                            </div>
                        </div>
                        <!-- end title -->
                        <div class="ot-contact-form mb-24">
                            <label for="note" class="ot-contact-label">{{ ___('event.Date') }} <span class="text-danger">*</span></label>
                            <input type="date" class="ot-contact-input" id="date" name="date" value="{{ old('date') }}" autocomplete="off" />
                        </div>

                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('instructor.Status') }}<span
                                    class="text-danger">*</span></label>
                            <select class="ot-contact modal_select2" required id="status_id" name="status_id">
                                @foreach ($data['status'] as $type)
                                    <option {{ old('status_id') == $type->id ? 'selected' : '' }}
                                        value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
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
