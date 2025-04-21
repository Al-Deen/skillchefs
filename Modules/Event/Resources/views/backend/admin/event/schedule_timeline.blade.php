<div class="page-content">
    <!--  table content start -->
    <div class="table-content table-basic ecommerce-components product-list">
        <div class="card">
            <div class="card-body">
                <div class="col-xl-12">
                    <div
                        class="small-tittle-two border-bottom d-flex align-items-center justify-content-between mb-20 pb-8">

                        <div class="country d-flex align-items-center mb-10">
                            <i class="ri-briefcase-line"></i>
                            <span
                                class="country text-title font-600 ml-10">{{ ___('event.Schedule Timeline') }}</span>
                        </div>
                        <button class="btn btn-lg ot-btn-primary mb-6"
                            onclick="mainModalOpen(`{{ route('event.admin.schedules_timeline.create', encryptFunction($data['event_schedule']->id)) }}`)">
                            <i class="fa-solid fa-plus"></i> {{ ___('event.add schedule timeline') }}
                        </button>
                    </div>
                </div>
                <!--  table start -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead">
                            <tr>
                                <th>{{ ___('event.ID') }}</th>
                                <th>{{ ___('event.Title') }}</th>
                                <th>{{ ___('event.Details') }}</th>
                                <th>{{ ___('event.Time Duration') }}</th>
                                <th>{{ ___('event.Location') }}</th>
                                <th>{{ ___('event.Status') }}</th>
                                <th>{{ ___('event.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @forelse ($data['schedule_timeline'] as $key => $schedule)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $schedule->title }}</td>
                                    <td>{{ Str::limit(@$schedule->details, 20) }}</td>
                                    <td>{{ showTime($schedule->from_time) }} - {{ showTime($schedule->to_time) }}</td>
                                    <td>{{ $schedule->location }}</td>
                                    <td>
                                        @if(@$schedule->status->name == 'Active')
                                        <span class="badge badge-basic-success-text">{{ ___('common.Active') }}</span>
                                        @else
                                        <span class="badge badge-basic-danger-text">{{ ___('common.Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <div class="dropdown dropdown-action">
                                            <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="mainModalOpen(`{{ route('event.admin.schedules_timeline.edit', encryptFunction($schedule->id)) }}`)">
                                                        <span class="icon mr-12"><i class="fa-solid fa-pen-to-square"></i></span>
                                                        {{ ___('common.edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item delete_data" href="javascript:void(0);" data-href="{{ route('event.admin.schedules_timeline.destroy', encryptFunction($schedule->id)) }}">
                                                        <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                        <span>{{ ___('common.delete') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <!-- empty table -->
                                @include('backend.ui-components.empty_table', [
                                    'colspan' => '7',
                                    'message' => ___(
                                        'message.Please add a new entity or manage the data table to see the content here'),
                                ])
                                <!-- empty table -->
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--  table end -->
                <!--  pagination start -->
                @include('backend.ui-components.pagination', ['data' => $data['schedule_timeline']])
                <!--  pagination end -->
            </div>
        </div>
    </div>
    <!--  table content end -->
</div>
