@forelse (@$data['enroll']->notes as $note)
    <div class="note_list_single">
        <div class="note_lingle_header gap-15 d-flex align-items-center justify-content-between">
            <div class="note_lingle_left d-flex align-items-center flex-wrap gap-18 flex-fill">
                <div class="d-flex align-items-center gap-12">
                    <h4>{{ @$note->lesson->section->title }}</h4>
                </div>
                <h5> - {{ @$note->lesson->title }}</h5>
            </div>
            <div class="d-flex align-items-center note_action">
                <a href="javascript:;" class="text-gray action-success" onclick="mainModalOpen(`{{  route('student.note.edit', encryptFunction($note->id) ) }}`)"><i class="ri-edit-2-fill"></i></a>
                <a href="javascript:;" class="ml-10 text-gray action-danger" onclick="destroyFunction(`{{  route('student.note.delete', encryptFunction($note->id) ) }}`)"><i class="ri-delete-bin-6-line"></i></a>
            </div>
        </div>
        <p class="note_description"><?= $note->description ?></p>
    </div>
@empty
    <div class="text-center">
        <h4 class="text-18 font-600">
            {{ ___('student.Notes_Not_Found') }}
        </h4>
    </div>
@endforelse
