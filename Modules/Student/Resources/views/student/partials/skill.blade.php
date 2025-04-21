<div class="card ot-card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between mb-20 pb-8">

                    <div class="country d-flex align-items-center mb-10">
                        <span class="country text-title font-600 ml-10">
                            {{ ___('student.Skills & Expertise') }}
                        </span>
                    </div>
                    <button class="btn btn-lg ot-btn-primary mb-6"
                        onclick="mainModalOpen(`{{ route('admin.student.add.skill', @$data['student']->user_id) }}`)">
                        <i class="fa-solid fa-plus"></i>
                        {{ ___('student.add new') }}</button>
                </div>
            </div>
            <div class="row">
                <div class="single-education mb-30 d-flex justify-content-between align-items-start">
                    <div class="tag-area3">
                        <ul class="listing p-0">
                            @if (@$data['student']->skills)
                                @foreach (@$data['student']->skills as $key => $skill)
                                    <li class="single-list">{{ @$skill['value'] }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="d-flex gap-10">
                        <button class="btn text-primary border-0 p-0"
                            onclick="mainModalOpen(`{{ route('admin.student.add.skill', @$data['student']->user_id) }}`)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
