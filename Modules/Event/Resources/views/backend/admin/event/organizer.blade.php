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
                                class="country text-title font-600 ml-10">{{ ___('event.Organizers') }}</span>
                        </div>
                        <button class="btn btn-lg ot-btn-primary mb-6"
                            onclick="mainModalOpen(`{{ route('event.admin.organizer.create', encryptFunction($data['event']->id)) }}`)">
                            <i class="fa-solid fa-plus"></i> {{ ___('event.add organizer') }}
                        </button>
                    </div>
                </div>
                <!--  table start -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead">
                            <tr>
                                <th>{{ ___('event.ID') }}</th>
                                <th>{{ ___('event.Organizer Name') }}</th>
                                <th>{{ ___('event.Email') }}</th>
                                <th>{{ ___('event.Phone') }}</th>
                                <th>{{ ___('event.Profile Image') }}</th>
                                <th>{{ ___('event.Status') }}</th>
                                <th>{{ ___('event.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @forelse ($data['organizer'] as $key => $organizer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $organizer->name }}</td>
                                    <td>{{ $organizer->email }}</td>
                                    <td>{{ $organizer->phone }}</td>
                                    <td>
                                        <img class="img-fluid rounded-circle" src="{{ showImage(@$organizer->image->original, 'default-1.jpeg') }}" width="50" alt="profile image">
                                    </td>
                                    <td>
                                        @if(@$organizer->status->name == 'Active')
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
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="mainModalOpen(`{{ route('event.admin.organizer.edit', encryptFunction($organizer->id)) }}`)">
                                                            <span class="icon mr-12"><i class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.edit') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item delete_data" href="javascript:void(0);" data-href="{{ route('event.admin.organizer.destroy', encryptFunction($organizer->id)) }}">
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
                @include('backend.ui-components.pagination', ['data' => $data['organizer']])
                <!--  pagination end -->
            </div>
        </div>
    </div>
    <!--  table content end -->
</div>
