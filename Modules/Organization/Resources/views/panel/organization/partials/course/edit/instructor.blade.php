<div class="step-wrapper-contents">
    <div class="step-5">
        <!-- Title -->
        <div class="setp-page-title mb-20">
            <h4 class="title font-600">
                <i class="ri-user-3-line"></i>{{ ___('instructor.Course_Instructor') }}
            </h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Instructor') }} </label>
                    <select class="instructor_select_multiple form-control" multiple="multiple" data-placeholder="{{ ___('placeholder.Select Instructor') }}" name="instructors[]">
                        @foreach ($data['instructors'] as $value)
                            <option value="{{ $value->user->id }}" {{ in_array($value->user->id, json_decode($data['instructor_id_values'])) ? 'selected':'' }}>{{ $value->user->name }}</option>
                        @endforeach
                    </select>
                    <div class="mt-3">
                        @foreach($data['instructor_commission'] as $value)
                        <div class='row' id="instructor_{{  $value->user->id }}">
                            <div class="col-xl-6 col-md-6 mb-3">
                                <input type="text" class="form-control ot-input col-xl-6 col-md-6" value="{{ $value->user->name }}" disabled/>
                            </div>
                            <div class="col-xl-5 col-md-5 mb-3">
                                <input type="text" name="commissions[{{ $value->user->id }}]" value="{{ $value->commission }}" min="0" max="100" placeholder="commission" id="commission_{{ $value->user->id }}" class="form-control ot-input col-xl-6 col-md-6"/>
                            </div>
                            <div class="col-xl-1 col-md-1 mb-3">
                                <a class="btn btn-danger remove ri-delete-bin-line" value="{{ $value->user->id }}" data-id="{{ $value->user->id }}"></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-1" id="show_instructor_fields"></div>
                </div>
            </div>
        </div>
    </div>
</div>
