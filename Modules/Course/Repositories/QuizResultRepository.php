<?php

namespace Modules\Course\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Modules\Order\Entities\Note;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Enroll;
use Illuminate\Support\Facades\Log;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Review;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Entities\Question;
use Modules\Course\Entities\QuizResult;
use Modules\Course\Interfaces\QuizResultInterface;

class QuizResultRepository implements QuizResultInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $enrollModel;

    public function __construct(QuizResult $quizResultModel, Course $courseModel, User $userModel, Enroll $enrollModel)
    {
        $this->model = $quizResultModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->enrollModel = $enrollModel;
    }

    public function model()
    {
        return $this->model;
    }


    public function store($data)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $enroll_id = $data['enroll_id'];
            $quiz_result = $this->model->where('user_id', Auth::id())->where('enroll_id', $enroll_id)->where('quiz_id', $data['quiz_id']) ->first();
            if ($quiz_result) {
                return $this->responseWithSuccess(___('alert.Quiz result already created successfully.'), $quiz_result); // return success response
            }
            $quiz_result = new $this->model;
            $quiz_result->user_id = Auth::id();
            $quiz_result->quiz_id = $data['quiz_id'];
            $quiz_result->enroll_id = $enroll_id;
            $quiz_result->status_id = 24;
            $quiz_result->save();

            $enroll = $this->enrollModel->where('user_id', Auth::id())->where('id', $quiz_result->enroll_id)->first();
            $completed_quizzes = $enroll->completed_quizzes;
            $progress = 0;
            if (!$completed_quizzes) {
                $completed_quizzes = [];
            }
            $completed_quizzes = array_merge($completed_quizzes, [$quiz_result->quiz_id]);
            $completed_quizzes = array_unique($completed_quizzes);
            $progress = number_format(((count($completed_quizzes) + count($enroll->completed_lessons ??  []) + count(@$enroll->completed_assignments ?? []) ) / ( $enroll->lessons->count() + $enroll->course->activeAssignments->count() ) ) * 100, 2);
            $enroll->update([
                'completed_quizzes' => $completed_quizzes,
                'progress' => $progress,
            ]);
            if ($progress == 100 && $enroll->is_completed == 0) {
                $enroll->completed($enroll);
            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Quiz result created successfully.'), $quiz_result); // return success response
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
