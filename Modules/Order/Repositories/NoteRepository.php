<?php

namespace Modules\Order\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Modules\Order\Entities\Note;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Enroll;
use Illuminate\Support\Facades\Log;
use Modules\Course\Entities\Course;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Interfaces\NoteInterface;

class NoteRepository implements NoteInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $enrollModel;

    public function __construct(Note $noteModel, Course $courseModel, User $userModel, Enroll $enrollModel)
    {
        $this->model = $noteModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->enrollModel = $enrollModel;
    }

    public function model()
    {
        return $this->model;
    }


    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $lesson_id = ($request->lesson_id);
            $enroll = $this->enrollModel->where('user_id', Auth::id())->whereHas('lessons', function ($q) use ($lesson_id) {
                $q->where('id', $lesson_id);
            })->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.Lesson not found'), [], 400); // return error response
            }

            $note = new $this->model;
            $note->enroll_id = $enroll->id;
            $note->user_id = Auth::id();
            $note->lesson_id = $lesson_id;
            $note->description = $request->note;
            $note->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note created successfully.'), $note); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $note = $this->model()->where('user_id', Auth::id())->find($id);
            if (!$note) {
                return $this->responseWithError(___('alert.Note not found'), [], 400); // return error response
            }
            $note->description = $request->note;
            $note->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $enroll = $this->model()->find($id);
            if (!$enroll) {
                return $this->responseWithError(___('alert.Note not found'), [], 400); // return error response
            }
            $enroll->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
