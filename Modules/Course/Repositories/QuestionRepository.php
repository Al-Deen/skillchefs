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
use Modules\Course\Interfaces\QuestionInterface;

class QuestionRepository implements QuestionInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $enrollModel;

    public function __construct(Question $QuestionModel, Course $courseModel, User $userModel, Enroll $enrollModel)
    {
        $this->model = $QuestionModel;
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
            $answers = [];
            foreach ($request->answers as $key => $answer) {
                $answers[$key] = $request->options[$answer];
            }
            $question = new $this->model;
            $question->course_id = $request->course_id;
            $question->quiz_id = $request->lesson_id;
            $question->title = $request->question_title;
            $question->type = $request->type;
            $question->total_options = $request->total_options;
            $question->options =  json_encode($request->options);
            $question->answer = json_encode($answers);
            $question->created_by = Auth::id();
            $question->updated_by = Auth::id();
            $question->save();

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Question created successfully.'), $question); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            foreach ($request->answers as $key => $answer) {
                $answers[$key] = $request->options[$answer];
            }
            $question = $this->model()->find($id);
            $question->title = $request->question_title;
            $question->type = $request->type;
            $question->total_options = $request->total_options;
            $question->options = json_encode($request->options);
            $question->answer = json_encode($answers);
            $question->updated_by = Auth::id();
            $question->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Question updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }


    public function sortable($request, $id)
    {
        DB::beginTransaction();
        try {
            $course = $this->courseModel->where('id', $id)->where('created_by', auth()->user()->id)->first();
            if (!$course) {
                return $this->responseWithError(___('alert.Course not found.'), [], 400);
            }
            foreach ($request->data as $key => $question_id) {
                $question = $this->model->find($question_id);
                $question->order = $key + 1;
                $question->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.Question ordered successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $question = $this->model()->find($id);
            if (!$question) {
                return $this->responseWithError(___('alert.Question not found'), [], 400); // return error response
            }
            $question->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Question deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    
}
