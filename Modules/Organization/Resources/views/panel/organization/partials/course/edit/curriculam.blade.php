<div class="step-wrapper-contents  active course_id" data-id="{{ $data['course']->id }}">
    <!-- Step 2 -->
    <div class="step-2">
        <div class="row">
            <div class="col-lg-12">
                <!-- Title -->
                <div class="setp-page-title mb-20">
                    <h4 class="title font-600">
                        <i class="ri-book-open-line"></i> {{ ___('or.Course Curriculum') }}
                    </h4>
                </div>
                <!-- What Students Will Learn -->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('organization.Sections') }} </label>
                    <!-- Add New -->
                    <a href="javascript:;" data-url="{{ route('organization.section.add', $data['course']->slug) }}"
                        class="add-new-section main-modal-open"><i class="ri-add-line"></i>
                        {{ ___('organization.Add New Sections') }}</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="custom-accordion connected-sortable droppable-area1">
                    @foreach ($data['course']->sections as $section)
                        <!-- Single accordion -->
                        <div class="single-accordion draggable-item" data-id="{{ $section->id }}">
                            <h4 class="course-section-title font-500 line-clamp-1 d-flex justify-content-between">
                                {{ ___('organization.Section') }}
                                {{ $section->order }} :
                                {{ ucfirst($section->title) }}
                                <div class="div">
                                    <a href="javascript:;" class="main-modal-open action-success"
                                        data-url="{{ route('organization.section.edit', $section->id) }}">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <a href="javascript:;" class="action-danger"
                                        onclick="deleteFunction(`{{ route('organization.section.delete', $section->id) }}`)">
                                        <i class="ri-delete-bin-line"></i>
                                    </a>
                                </div>
                            </h4>
                            <div class="accordion-body">
                                <ul class="connected-sortable-lesson listing lesson-droppable">
                                    @foreach ($section->allLesson as $key_lesson => $lesson)
                                        <li class="single-list lessons" data-id="{{ $lesson->id }}">
                                            <div class="d-flex align-items-center justify-content-between ">
                                                <div class="title">
                                                    @if ($lesson->is_quiz)
                                                        <i class="ri-question-line"></i>
                                                    @else
                                                        @if (in_array(@$lesson->lesson_type, ['Youtube', 'Vimeo', 'GoogleDrive', 'VideoFile']))
                                                            <i class="ri-play-circle-line"></i>
                                                        @elseif(@$lesson->lesson_type == 'Text')
                                                            <i class="ri-text"></i>
                                                        @elseif(@$lesson->lesson_type == 'ImageFile')
                                                            <i class="ri-image-fill"></i>
                                                        @elseif(@$lesson->lesson_type == 'DocumentFile' && @$lesson->attachment_type == 1)
                                                            <i class="ri-file-pdf-line"></i>
                                                        @elseif(@$lesson->lesson_type == 'DocumentFile' && @$lesson->attachment_type == 2)
                                                            <i class="ri-file-text-fill"></i>
                                                        @endif
                                                    @endif

                                                    {{ ___('organization.Lesson') }}
                                                    {{ @$key_lesson + 1 }} :
                                                    {{ @$lesson->title }}
                                                </div>
                                                <!--Edit DropDown -->
                                                <div class="uplode-edit">
                                                    <a href="javascript:;" class="main-modal-open  action-success"
                                                        data-url="{{ route('organization.lesson.edit', $lesson->id) }}">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                    <a href="javascript:;" class="action-danger"
                                                        onclick="deleteFunction(`{{ route('organization.lesson.delete', $lesson->id) }}`)">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @if ($lesson->is_quiz)
                                                <div class="title connected-sortable-question question-droppable">
                                                    @foreach (@$lesson->questions as $question)
                                                        <div class="component mb-15 questions" data-id="{{ $question->id }}">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <div class="title">
                                                                    {{ ___('organization.Question') }}
                                                                    {{ @$question->order }} :
                                                                    {{ @$question->title }}
                                                                </div>
                                                                <!--Edit DropDown -->
                                                                <div class="uplode-edit">
                                                                    <a href="javascript:;"
                                                                        class="main-modal-open  action-success"
                                                                        data-url="{{ route('organization.question.edit', $question->id) }}">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                    <a href="javascript:;" class=" action-danger"
                                                                        onclick="deleteFunction(`{{ route('organization.question.delete', $question->id) }}`)">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <a href="javascript:;"
                                                        data-url="{{ route('organization.question.add', $lesson->id) }}"
                                                        class="add-btn  main-modal-open">
                                                        <i class="ri-add-line"></i>
                                                        {{ ___('organization.Add New Question') }}
                                                    </a>
                                                </div>
                                            @endif
                                            <!-- Components -->
                                        </li>
                                    @endforeach
                                </ul>
                                <!-- Add New -->
                                <a href="javascript:;" data-url="{{ route('organization.lesson.add', $section->id) }}"
                                    class="add-btn  main-modal-open">
                                    <i class="ri-add-line"></i>
                                    {{ ___('organization.Add New Lesson & Quiz') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                    <!-- Single accordion -->
                </div>
            </div>
        </div>
    </div>
</div>
