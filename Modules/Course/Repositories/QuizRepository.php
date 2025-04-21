<?php

namespace Modules\Course\Repositories;

use App\Models\Status;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Lesson;
use Modules\Course\Entities\Section;
use Modules\Course\Interfaces\QuizInterface;

class QuizRepository implements QuizInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $courseModel;
    private $sectionModel;
    protected $userModel;
    protected $statusModel;

    public function __construct(Lesson $lessonModal, Section $sectionModel, Course $courseModel, User $userModel, Status $statusModel)
    {
        $this->model = $lessonModal;
        $this->sectionModel = $sectionModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->statusModel = $statusModel;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Title'),
            ___('course.Section'),
            ___('course.Marks'),
            ___('course.Duration'),
            ___('course.Questions'),
            ___('ui_element.action'),
        ];
    }

    public function model()
    {
        return $this->model;
    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function params($params = null)
    {
        $instructor = $params->instructor_id ?? null;
        $search = $params->search ?? null;
        return [
            'instructor' => $this->userModel->where('id', $instructor)->first()->name ?? null,
            'search' => $search,
        ];
    }

    public function store($request)
    {
        DB::beginTransaction(); // start database transaction
        try {
            // find sections by section_id
            $section = $this->sectionModel->where('id', $request->section_id)->first();
            if (!$section) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400);
            }
            $newQuizModel = new $this->model; // create new object of model for store data in database table
            $newQuizModel->title = $request->title;
            $newQuizModel->course_id = $request->course_id;
            $newQuizModel->section_id = $request->section_id;
            $newQuizModel->duration = $request->duration;
            $newQuizModel->marks = $request->marks;
            $newQuizModel->instruction = $request->instruction;
            $newQuizModel->is_quiz = 1;
            $newQuizModel->order = $this->model->where('section_id', $request->section_id)->count() + 1;
            $newQuizModel->created_by = auth()->user()->id;
            $newQuizModel->updated_by = auth()->user()->id;
            $newQuizModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course quiz created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $newQuizModel = $this->model->find($id);
            if (!$newQuizModel) {
                return $this->responseWithError(___('alert.course_quiz_not_found'), [], 400);
            }
            $newQuizModel->title = $request->title;
            $newQuizModel->title = $request->title;
            $newQuizModel->instruction = $request->instruction;
            $newQuizModel->updated_by = auth()->user()->id;
            $newQuizModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course quiz updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $newQuizModel = $this->model->find($id);
            $newQuizModel->delete();
            return $this->responseWithSuccess(___('alert.Course quiz deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
