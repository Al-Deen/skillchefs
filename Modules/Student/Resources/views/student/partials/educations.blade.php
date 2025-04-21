<div class="card ot-card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between mb-20 pb-8">

                    <div class="country d-flex align-items-center mb-10">
                        <span class="country text-title font-600 ml-10">{{ ___('student.Educations') }}</span>
                    </div>
                    <button class="btn btn-lg ot-btn-primary mb-6"
                        onclick="mainModalOpen(`{{ route('admin.student.addInstitute', @$data['student']->user_id) }}`)">
                        <i class="fa-solid fa-plus"></i>
                        {{ ___('student.add new') }}</button>
                </div>
            </div>
            <div class="row">
                @if (@$data['student']->education)
                    @foreach (@$data['student']->education as $key => $institute)
                        <div class="col-xl-12">
                            <div class="single-education mb-30 d-flex justify-content-between align-items-start">

                                <div class="education-cap">
                                    <h4 class="text-18 text-tile mb-15">
                                        <a href="javascript:;">
                                            {{ @$institute['name'] }}
                                        </a>
                                    </h4>
                                    <p class="pera text-muted mb-6">
                                        {{ @$institute['degree'] }} - {{ @$institute['program'] }}
                                    </p>
                                    <p class="pera mb-20">
                                        {{ date('M y', strtotime(@$institute['start_date'])) }} -
                                        @if (@$institute['current'])
                                            {{ ___('student.Continue') }}
                                        @else
                                            {{ date('M y', strtotime(@$institute['end_date'])) }}
                                        @endif
                                    </p>
                                    <p class="pera mb-6">
                                        <?= @$institute['description'] ?>
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
                                                    data-url="{{ route('admin.student.edit.institute', [$key, @$data['student']->user_id]) }}"><span
                                                        class="icon mr-12">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </span>
                                                    {{ ___('common.Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete_data" href="javascript:;"
                                                    data-href="{{ route('admin.student.delete.institute', [$key, @$data['student']->user_id]) }}"><span
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
