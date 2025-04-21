<div class="step-wrapper-contents ">
    <!-- Step 1 -->
    <div class="step-1">
        <!-- Title -->
        <div class="setp-page-title mb-20">
            <h4 class="title font-600">
                <i class="ri-folder-add-line"></i> {{ ___('course.General') }}
            </h4>
        </div>
        <div class="row">
            <!-- Course Title -->
            <div class="col-lg-12">
                <div class="ot-contact-form course-title mb-24">
                    <input class="form-control ot-contact-input" type="text" name="title" id="title"
                        value="{{ $data['course']->title }}" placeholder="{{ ___('placeholder.Course Title....') }}">
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Select Categories -->
                <div class="ot-contact-form mb-24">
                    <div class="ot-contact-form">
                        <label class="ot-contact-label">{{ ___('label.Category') }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-control ot-contact-input select2" id="category" name="category">
                            @foreach ($data['categories'] as $category)
                                <?= categoryBacktracking($category->id, '', @$data['course']->course_category_id) ?>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">

                <div class="ot-contact-form mb-24">
                    <div class="ot-contact-form">
                        <label class="ot-contact-label">{{ ___('label.Visibility') }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-control ot-contact-input select2" id="visibility_id" required
                            name="visibility_id">
                            @foreach (courseVisibility() as $visibility)
                                <option value="{{ $visibility->id }}"
                                    {{ @$data['course']->visibility_id == $visibility->id ? ' selected="selected"' : '' }}>
                                    {{ $visibility->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Select level -->
                <div class="ot-contact-form mb-24">
                    <div class="ot-contact-form">
                        <label class="ot-contact-label">{{ ___('label.Level') }} <span
                                class="text-danger">*</span></label>
                        <select class="form-control ot-contact-input select2" name="course_level" id="course_level">
                            @foreach (courseLevel() as $level)
                                <option value="{{ $level->id }}"
                                    {{ @$data['course']->level_id == $level->id ? ' selected="selected"' : '' }}>
                                    {{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <!-- Select Language -->
                <div class="ot-contact-form mb-24">
                    <div class="ot-contact-form">
                        <label class="ot-contact-label">{{ ___('label.Language') }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-control ot-contact-input select2" name="language_id" id="language_id">
                            @foreach ($data['languages'] as $language)
                                <option value="{{ $language->code }}"
                                    {{ @$data['course']->language == $language->code ? ' selected="selected"' : '' }}>
                                    {{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--Select Course Type -->
                <div class="ot-contact-form mb-24">
                    <div class="ot-contact-form">
                        <label class="ot-contact-label">{{ ___('label.Course Type') }} <span
                                class="text-danger">*</span> </label>
                        <select class="form-control ot-contact-input select2" id="course_type" name="course_type">
                            @foreach (courseType() as $type)
                                <option value="{{ $type->id }}"
                                    {{ @$data['course']->course_type == $type->id ? ' selected="selected"' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Course Includes-->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('label.Short description') }}</label>
                    <textarea class="form-control ot-textarea @error('short_description') is-invalid @enderror" name="short_description"
                        id="short_description" rows="5" placeholder="{{ ___('placeholder.Enter Short Description') }}"><?= @$data['course']->short_description ?></textarea>
                </div>
                <!-- Course Descriptions [ CK Editor ]-->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('label.description') }}</label>
                    <textarea class="ckeditor-editor" placeholder="{{ ___('placeholder.Enter Description') }}" name="description"
                        id="description"><?= @$data['course']->description ?></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Course Includes-->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('label.Course Requirements') }}</label>
                    <textarea class="form-control ot-textarea ckeditor-editor " name="requirements" id="requirements" rows="5"
                        placeholder="{{ ___('placeholder.Enter Course Requirements') }}"><?= @$data['course']->requirements ?></textarea>
                </div>
                <!-- Course outcomes [ CK Editor ]-->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('label.Outcomes') }}</label>
                    <textarea class="ckeditor-editor" placeholder="{{ ___('placeholder.Enter outcomes') }}" name="outcomes" id="outcomes"><?= @$data['course']->outcomes ?></textarea>
                </div>
            </div>

        </div>
    </div>
</div>
