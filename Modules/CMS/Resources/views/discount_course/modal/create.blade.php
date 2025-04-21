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
                <form action="{{ $data['url'] }}" method="post" id="modal_values"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="course_id" class="form-label ">{{ ___('common.Course') }} <span
                                    class="fillable">*</span></label>
                            <select class="form-select ot-input course_list" id="course_id" required
                                data-url="{{ route('admin.discount-course.select') }}" name="course_id">
                                @if (@$data['course'])
                                    <option value="{{ $data['course']->id }}" selected>
                                        {{ @$data['course']->title }} - {{ showPrice( $data['course']->price) }}
                                    </option>
                                @else
                                    <option value="" selected>
                                        {{ ___('common.Select Course') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        {{-- start  discount  --}}
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="discount_price" class="form-label ">{{ ___('label.Course Discount') }}
                            </label>
                            <input class="form-control ot-input @error('title') is-invalid @enderror"
                                name="discount_price" list="datalistOptions" id="discount_price" min="0" value="{{@$data['course']->discount_price}}"
                                type="number" placeholder="{{ ___('placeholder.Enter Discount') }}">
                            @error('discount_price')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- end discount  --}}
                        {{-- start  discount type  --}}
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="discount_type" class="form-label ">{{ ___('label.Discount Type') }}
                            </label>
                            <select class="form-control modal_select2 ot-input" name="discount_type"
                                list="datalistOptions" id="discount_type"
                                placeholder="{{ ___('placeholder.Enter Discount Type') }}">
                                <option value="1" {{ @$data['course']->discount_type == 1 ? ' selected' : '' }}>
                                    {{ ___('course.Fixed') }}
                                </option>
                                <option value="2" {{ @$data['course']->discount_type == 2 ? ' selected' : '' }}>
                                    {{ ___('course.Percentage') }}
                                </option>
                            </select>
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
