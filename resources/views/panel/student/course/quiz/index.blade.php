<div>
    <div class="section-tittle text-center mb-60">
        <h4 class="small-title text-capitalize font-600">{{ $data['quiz']->section->title }} - {{ ___('student.Quiz') }}
        </h4>
        <span class="time text-20 mb-20 d-block text-capitalize"> {{ $data['quiz']->title }} -
            {{ $data['quiz']->questions->count() }}
            {{ ___('student.Questions') }}
        </span>
        @if ($data['quiz']->is_timer == 0)
            <span class="time d-flex gap-5 justify-content-center text-tertiary text-20 mb-20">
                <i class="ri-time-line"></i> {{ ___('student.Duration') }} :
                {{ minutes_to_hours($data['quiz']->duration) }}
            </span>
        @endif

    </div>
    <div class="mb-20">
        <div class="section-tittle-two mb-10">
            <h2 class="title font-600">{{ ___('student.Instruction') }} :</h2>
        </div>
        <div class="section-tittle-two mb-20">
            <?= $data['quiz']->instruction ?>
        </div>

    </div>

    <!-- Submit btn -->
    <div class="d-flex gap-10 align-items-center justify-content-center flex-wrap mt-20">
        <a href="javascript:;" onclick="quizStart(`{{ $data['url'] }}`)"
            class="btn-primary-fill mt-6 mr-10">{{ ___('student.Start now') }}</a>
    </div>
</div>
