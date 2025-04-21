<?php

namespace Modules\Course\Repositories;

use App\Events\FirebaseNotification;
use App\Models\Status;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Assignment;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Interfaces\AssignmentInterface;

class AssignmentRepository implements AssignmentInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $courseModel;
    protected $courseCategoryModel;
    protected $userModel;
    protected $statusModel;

    public function __construct(Assignment $assignmentModel, Course $courseModel, CourseCategory $courseCategoryModel, User $userModel, Status $statusModel)
    {
        $this->model = $assignmentModel;
        $this->courseModel = $courseModel;
        $this->courseCategoryModel = $courseCategoryModel;
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
            ___('common.Marks'),
            ___('common.Pass Marks'),
            ___('common.Deadline'),
            ___('ui_element.status'),
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
        $category = $params->category ?? null;
        $instructor = $params->instructor_id ?? null;
        $search = $params->search ?? null;
        return [
            'category' => $this->courseCategoryModel->active()->where('id', $category)->first()->title ?? null,
            'instructor' => $this->userModel->where('id', $instructor)->first()->name ?? null,
            'search' => $search,
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
            $assignmentModel = new $this->model; // create new object of model for store data in database table
            $assignmentModel->title = $request->title;
            $assignmentModel->details = $request->details;
            $assignmentModel->marks = $request->marks;
            $assignmentModel->pass_marks = $request->pass_marks;
            $assignmentModel->deadline = $request->deadline;
            $assignmentModel->course_id = $request->course_id;
            $assignmentModel->note = $request->note;
            $assignmentModel->status_id = $request->status_id;
            $assignmentModel->is_notify = @$request->is_notify ?? 0;
            $assignmentModel->created_by = auth()->user()->id;
            // assignment_file upload
            if ($request->hasFile('assignment_file')) {
                $upload = $this->uploadFile($request->assignment_file, 'course/assignment/assignment_file', [], '', 'file'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $assignmentModel->assignment_file = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $assignmentModel->save(); // save data in database table
            if ($assignmentModel->is_notify) {
                $title = ___('notification.New Assignment');
                $body = ___('notification.New Assignment has been added ') . ' "' . $assignmentModel->title . '"';
                event(new FirebaseNotification($course->enrolls, $title, $body));
            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course assignment created successfully.')); // return success response
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
            $assignmentModel = $this->model->find($id);
            if (!$assignmentModel) {
                return $this->responseWithError(___('alert.Course Assignment not found.'), [], 400);
            }
            $assignmentModel->title = $request->title;
            $assignmentModel->details = $request->details;
            $assignmentModel->marks = $request->marks;
            $assignmentModel->pass_marks = $request->pass_marks;
            $assignmentModel->deadline = $request->deadline;
            $assignmentModel->note = $request->note;
            $assignmentModel->status_id = $request->status_id;
            $assignmentModel->is_notify = @$request->is_notify ?? 0;
            // assignment_file upload
            if ($request->hasFile('assignment_file')) {
                $upload = $this->uploadFile($request->assignment_file, 'course/assignment/assignment_file', [], $assignmentModel->assignment_file, 'file'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $assignmentModel->assignment_file = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $assignmentModel->save(); // save data in database table
            if ($assignmentModel->is_notify) {
                $title = ___('notification.Update Assignment');
                $body = ___('notification.Assignment has been updated') . ' "' . $assignmentModel->title . '"';
                event(new FirebaseNotification($assignmentModel->course->enrolls, $title, $body));
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course assignment  updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $assignmentModel = $this->model->find($id);
            $upload = $this->deleteFile($assignmentModel->assignment_file, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $assignmentModel->delete();
            return $this->responseWithSuccess(___('alert.Course assignment deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
