<div class="card ot-card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">

                    <div class="country d-flex align-items-center ">
                        <i class="ri-open-arm-line"></i>
                        <span class="country text-title font-600 ml-10">{{ ___('student.Experiences') }}</span>
                    </div>
                    <button class="btn btn-lg ot-btn-primary"
                        onclick="mainModalOpen(`{{ route('admin.student.add.experience', @$data['student']->user_id) }}`)">
                        <i class="fa-solid fa-plus"></i> {{ ___('student.add new') }}</button>
                </div>
            </div>
            <div class="row">
                @if (@$data['student']->experience)
                    @foreach (@$data['student']->experience as $key => $experience)
                        <div class="col-xl-12">
                            <div class="single-education mb-30 d-flex justify-content-between align-items-start">
                                <div class="education-cap">
                                    <h4 class="text-18 text-tile mb-15">
                                        <a href="#">
                                            {{ @$experience['title'] }}
                                        </a>
                                    </h4>
                                    <p class="pera text-muted mb-6">
                                        {{ @$experience['name'] }} -
                                        <span
                                            class="text-title text-capitalize">{{ str_replace('_', ' ', @$experience['employee_type']) }}</span>

                                    </p>
                                    <p class="pera mb-6">
                                        {{ date('M y', strtotime(@$experience['start_date'])) }} -
                                        @if (@$experience['current'])
                                            {{ ___('student.Present') }} .
                                            {{ \Carbon\Carbon::parse(@$experience['start_date'])->diffForHumans() }}
                                        @else
                                            {{ date('M y', strtotime(@$experience['end_date'])) }}
                                        @endif
                                    </p>
                                    <p class="pera mb-20">
                                        {{ @$experience['location'] }}
                                    </p>
                                    <p class="pera mb-6">
                                        <?= @$experience['description'] ?>
                                    </p>
                                </div>

                                {{-- Button --}}
                                <div class="action d-flex gap-10">
                                    <div class="dropdown dropdown-action">
                                        <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item main-modal-open" href="javascript:;"
                                                    data-url="{{ route('admin.student.edit.experience', [$key, @$data['student']->user_id]) }}"><span
                                                        class="icon mr-12">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </span>
                                                    {{ ___('common.Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete_data" href="javascript:;"
                                                    data-href="{{ route('admin.student.delete.experience', [$key, @$data['student']->user_id]) }}"><span
                                                        class="icon mr-12">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </span>
                                                    {{ ___('common.Delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
                <!-- Educations end -->
            </div>
        </div>
    </div>
</div>
