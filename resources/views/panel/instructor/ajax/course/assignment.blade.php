<table class="table-responsive">
    <thead>
        <tr>
            {{ table_header('', @$data['tableHeader']) }}
        </tr>
    </thead>
    <tbody>
        @forelse ($data['assignments'] as $key => $course_assignment)
            <tr>
                <td>{{ @$key + 1 }}</td>
                <td>{{ Str::limit(@$course_assignment->title, 20) }}</td>
                <td> {{ @$course_assignment->marks }}</td>
                <td> {{ @$course_assignment->pass_marks }}</td>
                <td> {{ @$course_assignment->deadline }}</td>
                <td>
                    {{$course_assignment->status->name}}
                </td>

                <td class="action">
                    <div class="uplode-edit">
                        <a href="javascript:;" class="main-modal-open text-gray"
                            data-url="{{ route('instructor.assignment.edit', $course_assignment->id) }}">
                            <i class="ri-pencil-line"></i>
                        </a>
                        <a href="javascript:;" class="text-gray"
                            onclick="deleteFunction(`{{ route('instructor.assignment.delete', $course_assignment->id) }}`)">
                            <i class="ri-delete-bin-line"></i>
                        </a>
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
<?= $data['assignments']->links('frontend.partials.pagination-count', ['event' => 'instructor_assignment__paginate']) ?>
