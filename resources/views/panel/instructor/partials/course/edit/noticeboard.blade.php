<div class="step-wrapper-contents">
    <div class="step-4">
        <!-- Title -->
        <div class="setp-page-title mb-20 d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="title font-600">
                <i class="ri-file-list-3-line"></i>{{ ___('instructor.NoticeBoard') }}
            </h4>
            <a href="javascript:;" data-url="{{ route('instructor.noticeboard.add', $data['course']->id) }}"
                class="btn-primary-outline main-modal-open">
                {{ ___('instructor.Create NoticeBoard') }}
            </a>
        </div>
        <div class="row">

            <div class="col-xl-12">
                <div class="activity-table course-notice-board-load"
                    data-href="{{ route('ajax.instructor.course.noticeboard', $data['course']->id) }}">

                </div>
            </div>
        </div>

    </div>
</div>
