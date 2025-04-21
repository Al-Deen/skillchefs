<?php

namespace Modules\Course\Repositories;

use App\Models\Status;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Section;
use Modules\Course\Interfaces\SectionInterface;

class SectionRepository implements SectionInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $statusModel;

    public function __construct(Section $sectionModel, Course $courseModel, User $userModel, Status $statusModel)
    {
        $this->model = $sectionModel;
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
            ___('course.Lessons'),
            ___('course.Quizzes'),
            ___('common.Status'),
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

    public function createAttributes()
    {
        return [
            'title' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id' => 'title',
                'class' => 'form-control ot-form-control ot-input',
                'col' => 'col-md-12 form-group mb-3',
                'label' => ___('common.Title'),
            ],
            'status' => [
                'field' => 'select',
                'type' => 'select',
                'required' => true,
                'id' => 'status',
                'class' => 'form-select select2-input ot-input mb-3 modal_select2',
                'col' => 'col-md-12 form-group mb-3',
                'label' => ___('common.Status'),
                'options' => [
                    [
                        'text' => ___('common.Active'),
                        'value' => 1,
                        'active' => true,
                    ],
                    [
                        'text' => ___('common.Inactive'),
                        'value' => 2,
                        'active' => false,
                    ],
                ],
            ],

        ];
    }
    public function editAttributes($section)
    {
        return [
            'title' => [
                'field' => 'input',
                'type' => 'text',
                'required' => true,
                'id' => 'title',
                'class' => 'form-control ot-form-control ot-input',
                'col' => 'col-md-12 form-group mb-3',
                'label' => ___('common.Title'),
                'value' => $section->title,
            ],

        ];
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            // find course by course_id
            $course = $this->courseModel->where('id', $request->course_id)->first();
            if (!$course) {
                return $this->responseWithError(___('alert.Course not found.'), [], 400);
            }
            $sectionModel = new $this->model; // create new object of model for store data in database table
            $sectionModel->title = $request->title;
            $sectionModel->course_id = $request->course_id; // course_id
            $sectionModel->status_id = $request->status ?? 1;
            $sectionModel->created_by = auth()->user()->id;
            $sectionModel->updated_by = auth()->user()->id;
            $sectionModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course section created successfully.')); // return success response
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
            $sectionModel = $this->model->find($id);
            if (!$sectionModel) {
                return $this->responseWithError(___('alert.Course section not found.'), [], 400);
            }
            $sectionModel->title = $request->title;
            $sectionModel->status_id = $request->status ?? 1;
            $sectionModel->updated_by = auth()->user()->id;
            $sectionModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course section  updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
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
            foreach ($request->data as $key => $section_id) {
                $sectionModel = $this->model->find($section_id);
                $sectionModel->order = $key + 1;
                $sectionModel->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course section ordered successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $sectionModel = $this->model->find($id);
            $sectionModel->delete();
            return $this->responseWithSuccess(___('alert.Course section deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
