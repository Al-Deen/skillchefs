<div class="step-wrapper-contents ">
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
                    <select class="instructor_select_multiple form-control" name="instructors[]"
                        data-placeholder="{{ ___('placeholder.Select Instructor') }}" multiple>
                        @foreach ($data['instructors'] as $value)
                            <option value="{{ $value->user->id }}">{{ $value->user->name }}</option>
                        @endforeach
                    </select>
                    <div class="mt-3" id="show_instructor_fields"></div>

                </div>
            </div>
        </div>
    </div>
</div>
