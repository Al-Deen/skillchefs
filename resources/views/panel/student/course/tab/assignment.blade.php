@forelse (@$data['enroll']->course->activeAssignments()->orderBy('id',  'desc')->get() as $assignment)
    @php
        $submission = @$assignment
            ->assignmentSubmit()
            ->where('user_id', $data['enroll']->user_id)
            ->first();
    @endphp
    <li class="single-list-assignment">
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <h6 class="title mb-10">{{ $assignment->title }} </h6>
                <small class="text-12 text-tertiary mt-10">{{ ___('student.Marks') }} : {{ $assignment->marks }}
                    @if (@$submission->is_submitted == 11)
                        <p
                            class="text-14 text-{{ @$submission->status->class }}">{{ @$submission->status->name }}</p>
                        @if ($submission->is_reviewed == 1)
                            {{ ___('student.Obtained Mark') }}: <strong
                                class="text-title font-500">{{ @$submission->marks }}</strong>
                        @endif
                    @endif
                </small>
            </span>
            <div class="d-flex align-items-center  note_action">
                <span class="gap-3 text-tertiary text-14">
                    <i class="ri-time-line"></i>
                </span>
                <span class="assignment-date ms-1 text-14">
                    {{ date('d M Y, h:i a', strtotime($assignment->deadline)) }}</span>
                @if (@$submission->is_submitted == 11)
                    <span class="ms-1 text-14 text-success">{{ ___('student.Submitted') }}</span>
                @else
                    @if (date('Y-m-d H:i:s') > $assignment->deadline)
                        <span class="ms-1 text-14 text-danger">{{ ___('student.Expired') }}</span>
                    @else
                        <div class="edits">
                            <button
                                onclick="mainModalOpen(`{{ route('student.assignment.details', [encryptFunction($data['enroll']->id), encryptFunction($assignment->id)]) }}`)"><i
                                    class="ri-attachment-line"></i></button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </li>
@empty
    <li class="single-list-assignment">
        <div class="d-flex justify-content-between">
            <h6 class="title">{{ ___('course.No Assignment Found') }} </h6>
        </div>
    </li>
@endforelse
