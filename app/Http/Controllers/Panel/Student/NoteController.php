<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Http\Requests\NoteRequest;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Order\Interfaces\NoteInterface;

class NoteController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $enrollRepository;
    protected $noteRepository;
    protected $template = 'panel.student';

    public function __construct(EnrollInterface $enrollRepository, NoteInterface $noteRepository)
    {
        $this->enrollRepository = $enrollRepository;
        $this->noteRepository = $noteRepository;
    }
    public function NoteCreate($lesson_id)
    {
        try {
            $lesson_id = decryptFunction($lesson_id);
            $enroll = $this->enrollRepository->model()->where('user_id', Auth::id())->whereHas('lessons', function ($q) use ($lesson_id) {
                $q->where('id', $lesson_id);
            })->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.Lesson not found'), [], 400); // return error response
            }
            $data['url'] = route('student.note.store', encryptFunction($lesson_id)); // url
            $data['title'] = ___('course.Create Note'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.student.course.modal.note.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function noteStore(NoteRequest $request, $lesson_id)
    {
        try {
            $lesson_id = decryptFunction($lesson_id);
            $request->merge(['lesson_id' => $lesson_id]);
            $result = $this->noteRepository->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function noteEdit($id)
    {
        try {
            $note_id = decryptFunction($id);
            $data['note'] = $this->noteRepository->model()->find($note_id); // data
            if (!$data['note']) {
                return $this->responseWithError(___('alert.course_lesson_not_found'), [], 400); // return error response
            }
            $data['url'] = route('student.note.update', $id); // url
            $data['title'] = ___('course.Edit Note'); // title
            @$data['button'] = ___('common.Update');
            $html = view('panel.student.course.modal.note.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function noteUpdate(NoteRequest $request, $id)
    {
        try {
            $note_id = decryptFunction($id);
            $result = $this->noteRepository->update($request, $note_id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function noteDelete($id)
    {
        try {
            $note_id = decryptFunction($id);
            $result = $this->noteRepository->destroy($note_id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
