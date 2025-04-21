<?php

namespace Modules\Course\Repositories;

use App\Events\FirebaseNotification;
use App\Models\Status;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Entities\NoticeBoard;
use Modules\Course\Interfaces\NoticeboardInterface;

class NoticeboardRepository implements NoticeboardInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $courseModel;
    protected $courseCategoryModel;
    protected $userModel;
    protected $statusModel;

    public function __construct(NoticeBoard $noticeModel, Course $courseModel, CourseCategory $courseCategoryModel, User $userModel, Status $statusModel)
    {
        $this->model = $noticeModel;
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
            ___('common.Description'),
            ___('course.Notify'),
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
            $noticeModel = new $this->model; // create new object of model for store data in database table
            $noticeModel->title = $request->title;
            $noticeModel->course_id = $request->course_id;
            $noticeModel->description = $request->description;
            $noticeModel->is_send_mail = $request->is_send_mail ?? 0;
            $noticeModel->created_by = auth()->user()->id;
            $noticeModel->updated_by = auth()->user()->id;
            $noticeModel->save(); // save data in database table
            if ($request->is_send_mail == 1) {
                $title = ___('notification.Creating a new course noticeboard');
                $body = ___('notification.New course noticeboard has been created for course') . ' ' . $noticeModel->title;
                event(new FirebaseNotification($course->enrolls, $title, $body));
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course noticeboard created successfully.')); // return success response
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
            $noticeModel = $this->model->find($id);
            if (!$noticeModel) {
                return $this->responseWithError(___('alert.Course noticeboard not found.'), [], 400);
            }
            $noticeModel->title = $request->title;
            $noticeModel->description = $request->description;
            $noticeModel->is_send_mail = $request->is_send_mail ?? 0;
            $noticeModel->updated_by = auth()->user()->id;
            $noticeModel->save(); // save data in database table
            if ($request->is_send_mail == 1) {
                $title = ___('notification.Update course noticeboard');
                $body = ___('notification.Course noticeboard has been updated for course') . ' ' . $noticeModel->title;
                event(new FirebaseNotification($noticeModel->course->enrolls, $title, $body));
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course noticeboard  updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $noticeModel = $this->model->find($id);
            $noticeModel->delete();
            return $this->responseWithSuccess(___('alert.Course noticeboard deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
