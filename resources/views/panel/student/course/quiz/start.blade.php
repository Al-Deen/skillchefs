<div class="quize-text-wrapper" id="quiz_id"
    data-id="{{ encryptFunction(@$data['quiz']->id) }}">
    <!-- Title -->
    <div class="section-tittle border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10"
        id="quiz-result-container" data-id="{{ $data['quiz_result_id'] }}">
        <h4 class="small-title text-capitalize font-600">{{ ___('student.Quiz') }} </h4>
        <span class="time d-flex gap-5 text-tertiary text-20">
            <i class="ri-time-line"></i>
            <strong id="time_count"></strong>
        </span>
    </div>
    <div class="small-tittle-two  d-flex align-items-center justify-content-between flex-wrap mb-30 pb-8">
        <p class="text-18 font-400 text-secondary">{{ ___('student.Questions') }}: <strong class="text-title font-500"
                id="question-number"></strong></p>
        <p class="text-18 font-400 text-secondary">{{ ___('student.Total Marks') }}: <strong
                class="text-title font-500">{{ @$data['quiz']->marks }}</strong></p>
    </div>

    <div id="question_list">

    </div>
</div>
