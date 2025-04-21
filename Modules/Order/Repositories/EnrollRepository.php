<?php

namespace Modules\Order\Repositories;

use App\Enums\Role;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Entities\Income;
use Modules\Accounts\Interfaces\IncomeInterface;
use Modules\Course\Entities\Course;
use Modules\Order\Entities\Enroll;
use Modules\Order\Interfaces\EnrollInterface;

class EnrollRepository implements EnrollInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $income;

    public function __construct(Enroll $enrollModel, Course $courseModel, User $userModel, IncomeInterface $incomeRepository)
    {
        $this->model = $enrollModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->income = $incomeRepository;
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

    public function store($orders)
    {
        DB::beginTransaction(); // start database transaction
        try {
            foreach ($orders->orderItems as $order_item) {
                $enrollModel = new $this->model;
                $enrollModel->order_item_id = $order_item->id;
                $enrollModel->course_id = $order_item->course_id;
                $enrollModel->user_id = $orders->user_id;
                $enrollModel->instructor_id = $order_item->course->created_by;
                $enrollModel->save();

                $enrollModel->course->update([
                    'total_sales' => @$enrollModel->course->total_sales + 1,
                ]);

                if ($enrollModel->teacher->role_id == Role::INSTRUCTOR) { // instructor
                    $instructor = $enrollModel->teacher->instructor;
                } else { // organization
                    $instructor = $enrollModel->teacher->organization;
                }
                if (@$instructor) {
                    $instructor->update([
                        'balance' => $instructor->balance + $order_item->instructor_amount,
                        'earnings' => $instructor->earnings + $order_item->instructor_amount,
                    ]);
                }
                $this->income->store([
                    'amount' => $order_item->total_amount,
                    'note' => ___('common.Course sale'),
                ]);
            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Enroll created successfully.'), $enrollModel); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $enroll = $this->model()->where('user_id', Auth::id())->whereHas('lessons', function ($q) use ($request) {
                $q->where('id', decryptFunction($request->lesson_id));
            })->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.Lesson not found'), [], 400); // return error response
            }
            $completed_lessons = [];
            $progress = 0;
            $lesson_point = 0;
            if (@$request->completed_lessons) {
                $completed_lessons = array_map(function ($item) {
                    return decryptFunction($item);
                }, @$request->completed_lessons);
                $completed_lessons = array_unique($completed_lessons);
                $progress = number_format(((count($completed_lessons) + count($enroll->completed_quizzes ?? []) + count(@$enroll->completed_assignments ?? [])) / ($enroll->lessons->count() + $enroll->course->activeAssignments->count())) * 100, 2);
                $lesson_point = DB::table('lessons')->whereIn('id', $completed_lessons)->sum('point');

                $enroll->update([
                    'completed_lessons' => $completed_lessons,
                    'progress' => $progress,
                    'lesson_point' => $lesson_point,
                ]);
                if ($progress == 100 && $enroll->is_completed == 0) {
                    $enroll->completed($enroll);
                }

            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Enroll updated successfully.')); // return success response
        } catch (\Throwable $th) {

            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function visited($enroll)
    {
        $enroll->update([
            'visited' => now(),
        ]);
    }
}
