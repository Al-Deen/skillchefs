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
use Modules\Course\Entities\Lesson;
use Modules\Course\Entities\Question;
use Modules\Course\Entities\QuestionSubmit;
use Modules\Course\Entities\QuizResult;
use Modules\Course\Interfaces\QuestionSubmitInterface;

class QuestionSubmitRepository implements QuestionSubmitInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    protected $quizModel;
    protected $enrollModel;
    protected $quizResultModel;
    protected $questionModel;

    public function __construct(QuestionSubmit $questionSubmitModel, Enroll $enrollModel, Lesson $quizModel, QuizResult $quizResultModel, Question $questionModel)
    {
        $this->model = $questionSubmitModel;
        $this->quizModel = $quizModel;
        $this->enrollModel = $enrollModel;
        $this->quizResultModel = $quizResultModel;
        $this->questionModel = $questionModel;
    }

    public function model()
    {
        return $this->model;
    }


    public function store($data)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $quiz_result = $this->quizResultModel->where('id', $data['quiz_id'])->first();
            if (!$quiz_result) {
                return $this->responseWithError(___('alert.Quiz not found'), [], 400); // return error response
            }
            // check answer is correct or not
            $question = $this->questionModel->where('id', $data['question_id'])->first();
            

            $question_submit = $this->model->where('user_id', Auth::id())->where('quiz_result_id', $quiz_result->id)->where('question_id', $data['question_id'])->first();
            if (!$question_submit) {
                $question_submit = new $this->model;
            }
            $is_correct = 0;
            if (@$question->answer  && json_encode(@$question->answer) == json_encode($data['answer'])) {
                $is_correct = 1;
            }
            $question_submit->user_id = Auth::id();
            $question_submit->quiz_result_id = $quiz_result->id;
            $question_submit->question_id = $data['question_id'];
            $question_submit->answer = $data['answer'];
            $question_submit->is_correct = $is_correct;
            $question_submit->save();
            // add marks to quiz result
            $given_marks = $quiz_result->quiz->marks;
            $total_questions = $quiz_result->quiz->questions->count();
            $marks = $given_marks / $total_questions;
            $final_marks = $marks * $quiz_result->questionSubmit()->where('is_correct', 1)->count();
            $quiz_result->marks = $final_marks;

            if (floatval($question->quiz->pass_marks) <= floatval($final_marks)) {
                $quiz_result->status_id = 25;
            } else {
                $quiz_result->status_id = 24;
            }

            $point  =  $quiz_result->quiz->point / $total_questions;
            $final_point = $point * $quiz_result->questionSubmit()->where('is_correct', 1)->count();
            if ($data['lastQuestion']) {
                $quiz_result->is_submitted = 11;
                $quiz_result->point = $final_point;
            }
            $quiz_result->save();

            // add point to enroll
            $enroll = $this->enrollModel->where('user_id', Auth::id())->where('course_id', $quiz_result->quiz->course_id)->first();
            if ($enroll) {
                $enroll->quiz_point = $enroll->quizResults()->sum('point');
                $enroll->save();
            }

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Question submit created successfully.'), $question_submit); // return success response
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
