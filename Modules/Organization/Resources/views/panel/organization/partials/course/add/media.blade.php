<div class="step-wrapper-contents">
    <div class="step-4">
        <!-- Title -->
        <div class="setp-page-title mb-20">
            <h4 class="title font-600">
                <i class="ri-image-line"></i>{{ ___('instructor.Course Media') }}
            </h4>
        </div>
        <div class="row">
            <!-- Course preview type -->
            <div class="col-lg-12">
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Course Preview Type') }} <span
                            class="text-danger">*</span></label>
                    <select class="form-control ot-contact-input select2" name="course_preview" id="course_preview">
                        @foreach (coursePreviewType() as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Course preview type -->
            <div class="col-lg-12">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Video URL') }} <span class="text-danger">*</span>
                    </label>
                    <input class="ot-contact-input"name="video_url" id="video_url"
                        placeholder="https://youtu.be/3l6Q4QL-j4Q">
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Thumbnail') }} </label>
                    <div data-name="thumbnail" class="file" data-height="200px "></div>
                    <small
                        class="text-muted">{{ ___('placeholder.NB : Thumbnail size will 600px x 600px and not more than 1mb') }}</small>
                        <div id="thumbnail"></div>
                </div>
            </div>

        </div>
    </div>
</div>
