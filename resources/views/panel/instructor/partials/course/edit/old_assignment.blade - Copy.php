<div class="step-wrapper-contents">
    <div class="step-4">
        <!-- Title -->
        <div class="setp-page-title mb-20 d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="title font-600">
                <i class="ri-file-list-3-line"></i>{{ ___('instructor.Assignment') }}
            </h4>
            <a href="javascript:;" data-url="{{ route('instructor.assignment.add', $data['course']->id) }}"
                class="btn-primary-outline main-modal-open">
                {{ ___('instructor.Create assignment') }}
            </a>
        </div>
        <div class="row">

            <div class="col-xl-12">
                <div class="activity-table course-assignment-load"
                    data-href="{{ route('ajax.instructor.course.assignment', $data['course']->id) }}">

                </div>
            </div>
        </div>

    </div>
</div>