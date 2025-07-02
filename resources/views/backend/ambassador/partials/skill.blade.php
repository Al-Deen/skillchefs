<div class="card ot-card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">

                    <div class="country d-flex align-items-center">
                        <span class="country text-title font-600 ml-10">
                            {{ ___('instructor.Skills & Expertise') }}
                        </span>
                    </div>
                    <button class="btn btn-lg ot-btn-primary"
                        onclick="mainModalOpen(`{{ route('admin.instructor.add.skill', @$data['instructor']->user_id) }}`)">
                        <i class="fa-solid fa-plus"></i>
                        {{ ___('instructor.add new') }}</button>
                </div>
            </div>
            <div class="row">
                <div class="single-education mb-30 d-flex justify-content-between align-items-start">
                    <div class="tag-area3">
                        <ul class="listing p-0">
                            @if (@$data['instructor']->skills)
                                @foreach (@$data['instructor']->skills as $key => $skill)
                                    <li class="single-list">{{ @$skill['value'] }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="d-flex gap-10">
                        <button class="btn text-primary border-0 p-0"
                            onclick="mainModalOpen(`{{ route('admin.instructor.add.skill', @$data['instructor']->user_id) }}`)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
