<!-- schedule Start -->
<div class="tab-pane fade show active">
    <div class="col-xl-12">
        <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">
            <div class="country d-flex align-items-center ">
                <i class="ri-calendar-todo-fill"></i>
                <span class="country text-title font-600 ml-10">{{ $data['title'] }}</span>
            </div>
            <button class="btn-primary-outline main-modal-open" data-url="{{ route('event.instructor.schedule.create', request()->id) }}">
                <i class="ri-add-line"></i> {{ ___('event.Add New Schedule') }}
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            @forelse ($data['schedules'] as $schedule)
                <div class="schedule mb-3">
                    {{-- Manage Start --}}
                    <div class="course-edit">
                        <div class="activity-dropdown">
                            <button class="dropdown-toggle"></button>
                            <ul class="dropdown" style="display: none;">
                                <li>
                                    <a href="javascript:void(0)"
                                        onclick="mainModalOpen(`{{ route('event.instructor.schedule.edit', encryptFunction($schedule->id)) }}`)"
                                        class="action-success">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="javascript:void(0)"
                                        onclick="deleteFunction(`{{ route('event.instructor.schedule.destroy', encryptFunction($schedule->id)) }}`)"
                                        class="action-danger">
                                        <i class="ri-delete-bin-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- Manage End --}}
                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="ot-contact-form mb-24">
                                <label class="ot-contact-label">{{ ___('event.Schedule Title') }}</label>
                                <p>{{ $schedule->title }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="ot-contact-form mb-24">
                                <label class="ot-contact-label">{{ ___('event.Date') }}</label>
                                <p>{{ showDate($schedule->date) }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="ot-contact-form mb-24">
                                <label class="ot-contact-label">{{ ___('event.Status') }}</label>
                                <br>
                                <span
                                    class="badge {{ 'badge-' . $schedule->status->class }}">{{ $schedule->status->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 d-flex justify-content-between">
                            <h6 class="ot-contact-label">{{ ___('event.Timeline List') }}</h6>
                            <h6 class="ot-contact-label"><a href="javascript:void(0)"
                                onclick="mainModalOpen(`{{ route('event.instructor.schedule.list.create', encryptFunction($schedule->id)) }}`)"><i
                                        class="ri-add-line"></i>{{ ___('event.Add Timeline') }}</a></h6>
                        </div>
                        <div class="timeline col-md-12">
                            <div class="schedule-table">
                                @forelse ($schedule->scheduleList as $schedule)
                                    <div class="row list-style {{ $schedule->status_id == 2 ? "inactive-item" : '' }}">
                                        <div class="col-lg-6 col-sm-6 field">@if($schedule->status_id == 2) <i class="ri-eye-off-line"></i> @endif {{ Str::limit($schedule->title, 20) }}</div>
                                        <div class="col-lg-2 col-sm-6">
                                            <div class="field"><i class="ri-time-line"></i><span>{{ showTime($schedule->from_time) }} - {{ showTime($schedule->to_time) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <div class="field"><i class="ri-map-pin-line"></i> <span>{{ Str::limit($schedule->location, 20) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <a href="javascript:void(0)"
                                        onclick="mainModalOpen(`{{ route('event.instructor.schedule.list.view', encryptFunction($schedule->id)) }}`)" class="action-success"><i class="ri-eye-line"></i></a>
                                        <a href="javascript:void(0)"
                                        onclick="mainModalOpen(`{{ route('event.instructor.schedule.list.edit', encryptFunction($schedule->id)) }}`)" class="action-tertiary"><i class="ri-edit-2-line"></i></a>
                                        <a href="javascript:void(0)"
                                    onclick="deleteFunction(`{{ route('event.instructor.schedule.list.destroy', encryptFunction($schedule->id)) }}`)" class="action-danger"><i
                                                class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <div colspan="4" class="text-center">{{ ___('event.No Timeline Added') }}</div>
                                    </div>
                                @endforelse
                                </div>
                        </div>
                    </div>
                </div>
            @empty
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="not-data-found table-img text-center pt-50 pb-10">
                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                            alt="img" class="w-100 mb-20 w-25">
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

    <!-- End-of schedule  -->
    <!--  pagination start -->
    {!! @$data['schedules']->links('frontend.partials.pagination-count') !!}
    <!--  pagination end -->
