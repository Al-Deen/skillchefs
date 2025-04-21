<div class="tab-pane fade show active">
    <div class="col-xl-12">
        <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">
            <div class="country d-flex align-items-center ">
                <i class="ri-building-4-line"></i>
                <span class="country text-title font-600 ml-10">{{ ___('event.Organizers') }}</span>
            </div>
            <button class="btn-primary-outline main-modal-open" data-url="{{ route('instructor.event.organizer.create', request()->id) }}">
                <i class="ri-add-line"></i> {{ ___('event.Add Organizer') }}
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="activity-table">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th>{{ ___('event.Organizer Name') }}</th>
                            <th>{{ ___('event.Email') }}</th>
                            <th>{{ ___('event.Phone') }}</th>
                            <th>{{ ___('event.Profile Image') }}</th>
                            <th>{{ ___('event.Status') }}</th>
                            <th>{{ ___('event.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['organizers'] as $organizer)
                            <tr>
                                <td>
                                    <h5 class="text-16 mb-6 text-tertiary">
                                        {{ @$organizer->name }}
                                    </h5>
                                </td>
                                <td>{{ $organizer->email }}</td>
                                <td>{{ $organizer->phone }}</td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-img">
                                            <img src="{{ showImage(@$organizer->image->original, 'default-1.jpeg') }}" alt="img" class="img-cover">
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    @if (@$organizer->status_id === 1)
                                        <span class="status-success"> {{ ___('student.Active') }} </span>
                                    @else
                                        <span class="status-danger"> {{ ___('student.Inactive') }} </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:;" class="action-success main-modal-open" data-url="{{ route('instructor.event.organizer.edit', encryptFunction($organizer->id)) }}">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    <a href="javascript:;" class="action-danger" onclick="deleteFunction(`{{ route('instructor.event.organizer.destroy', encryptFunction($organizer->id)) }}`)">
                                        <i title="Delete" class="ri-delete-bin-line"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <div class="not-data-found table-img text-center pt-50 pb-10">
                                                <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                                    alt="img" class="w-100 mb-20 w-25">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                 <!--  pagination start -->
                 {!! @$data['organizers']->links('frontend.partials.pagination-count') !!}
                 <!--  pagination end -->
            </div>
        </div>
    </div>
</div>
