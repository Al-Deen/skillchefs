<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead">
            <!-- start table header from ui-helper function -->
            {{ table_header('', @$data['tableHeader']) }}
            <!-- end table header from ui-helper function -->
        </thead>
        <tbody class="tbody">

            @forelse ($data['assignments'] as $key => $course_assignment)
                <tr>
                    <td>{{ @$key + 1 }}</td>
                    <td>{{ Str::limit(@$course_assignment->title, 20) }}</td>
                    <td> {{ @$course_assignment->marks }}</td>
                    <td> {{ @$course_assignment->pass_marks }}</td>
                    <td> {{ @$course_assignment->deadline }}</td>
                    <td>
                        {{ statusBackend(@$course_assignment->status->class, $course_assignment->status->name) }}
                    </td>

                    <td class="action">
                        <div class="dropdown dropdown-action">
                            <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">

                                @if (hasPermission('course_assignment_update'))
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('course.assignment.edit', $course_assignment->id) }}"><span
                                                class="icon mr-12"><i class="fa-solid fa-pen-to-square"></i></span>
                                            {{ ___('common.edit') }}</a>
                                    </li>
                                @endif
                                @if (hasPermission('course_assignment_delete'))
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="__globalDelete(`{{ route('course.assignment.destroy', $course_assignment->id) }}`)">
                                            <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                            <span>{{ ___('common.delete') }}</span>
                                        </a>
                                    </li>
                                @endif
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
@include('backend.ui-components.pagination', ['data' => $data['assignments']])
