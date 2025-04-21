<table class="table-responsive">
    <thead>
        <tr>
            {{ table_header('', @$data['tableHeader']) }}
        </tr>
    </thead>
    <tbody>
        @forelse ($data['notice_boards'] as $key => $course_notice_board)
            <tr>
                <td>{{ @$key + 1 }}</td>
                <td>{{ Str::limit(@$course_notice_board->title, 30) }}</td>
                <td> {{ Str::limit(@$course_notice_board->description, 20) }}</td>
                <td>
                    @if (@$course_notice_board->is_send_mail)
                        <span class="bs bs-success">{{ ___('common.yes') }}</span>
                    @else
                        <span class="bs bs-danger">{{ ___('common.no') }}</span>
                    @endif
                </td>

                <td class="action">
                    <div class="uplode-edit">
                        <a href="javascript:;" class="main-modal-open text-gray"
                            data-url="{{ route('instructor.noticeboard.edit', $course_notice_board->id) }}">
                            <i class="ri-pencil-line"></i>
                        </a>
                        <a href="javascript:;" class="text-gray"
                            onclick="deleteFunction(`{{ route('instructor.noticeboard.delete', $course_notice_board->id) }}`)">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <!-- empty table -->
            @include('backend.ui-components.empty_table', [
                'colspan' => '5',
                'message' => ___(
                    'message.Please add a new entity or manage the data table to see the content here'),
            ])
            <!-- empty table -->
        @endforelse
    </tbody>
</table>
<?= $data['notice_boards']->links('frontend.partials.pagination-count', ['event' => 'instructor_noticeboard__paginate']) ?>
