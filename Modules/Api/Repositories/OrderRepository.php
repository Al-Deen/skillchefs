<?php

namespace Modules\Api\Repositories;

use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Api\Interfaces\OrderInterface;
use Modules\Course\Entities\Course;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;

class OrderRepository implements OrderInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    private $orderItemModel;

    public function __construct(Order $orderModel, Course $courseModel, User $userModel, OrderItem $orderItemModel)
    {
        $this->model = $orderModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->orderItemModel = $orderItemModel;
    }

    public function all()
    {
        return $this->model->get();
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

    public function store($data)
    {

        DB::beginTransaction(); // start database transaction
        try {

            // store order data
            $amount = 0;
            $discount = 0;
            $tax = 0;
            $orderModel = new $this->model;
            $orderModel->invoice_number = $this->generateInvoiceNumber();
            $orderModel->user_id = $data['user_id'];
            $orderModel->payment_method = $data['payment_method'] ?? 'free';
            $orderModel->save();

            // store order items

            $course = $this->courseModel->find($data['course_id']);
            $orderItemModel = new OrderItem();
            $orderItemModel->order_id = $orderModel->id;
            $orderItemModel->course_id = $data['course_id'];
            $orderItemModel->amount = $course->price ?? 0;
            $orderItemModel->discount_amount = course_discount_price($course);
            $orderItemModel->total_amount = @$course->is_free == 0 ? $course->price - $orderItemModel->discount_amount : 0;
            $orderItemModel->tax_amount = tax_price($orderItemModel->total_amount);
            $orderItemModel->commission_amount = $orderItemModel->total_amount * (@$course->user->instructor->commission / 100);
            $orderItemModel->instructor_amount = $orderItemModel->total_amount - $orderItemModel->commission_amount;
            $orderItemModel->save();
            $amount += $orderItemModel->total_amount;
            $discount += $orderItemModel->discount_amount;
            $tax += $orderItemModel->tax_amount;

            // update order amount and discount
            $orderModel->amount = $amount + $discount;
            $orderModel->discount_amount = $discount;
            $orderModel->total_amount = $amount;
            $orderItemModel->tax_amount = $tax;
            $orderModel->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Order created successfully.'), $orderModel); // return success response
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
            $assignmentModel = $this->model->find($id);
            if (!$assignmentModel) {
                return $this->responseWithError(___('alert.Course Assignment not found.'), [], 400);
            }
            $assignmentModel->title = $request->title;
            $assignmentModel->details = $request->details;
            $assignmentModel->marks = $request->marks;
            $assignmentModel->deadline = $request->deadline;
            $assignmentModel->course_id = $request->course_id;
            $assignmentModel->note = $request->note;
            $assignmentModel->status_id = $request->status_id;
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

    // monthlySales

    public function monthlySales($request)
    {
        try {
            // month wise sales
            // 12 months with name  data with 0 value
            $labels = [];
            $info = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = date('F', mktime(0, 0, 0, $i, 10));
                $info[] = $this->model->where('status', 'paid')->whereMonth('created_at', $i)->sum('total_amount');
            }
            $monthlySales = [
                'labels' => $labels,
                'info' => $info,
                'currency' => getCurrencySymbol(),
            ];
            $message = [
                'title' => ___('instructor.Monthly Sales ,') . date('Y'),
                'type' => ___('instructor.Sales'),
            ];
            return $this->responseWithSuccess($message, $monthlySales, 200); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // instructorMonthlySales

    public function instructorMonthlySales($request)
    {
        try {
            // month wise sales
            // 12 months with name  data with 0 value
            $labels = [];
            $info = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = date('F', mktime(0, 0, 0, $i, 10));
                $info[] = $this->orderItemModel->with(['order', 'course'])
                    ->whereHas('order', function ($query) {
                        $query->where('status', 'paid');
                    })
                    ->whereHas('course', function ($query) {
                        $query->where('created_by', auth()->user()->id);
                    })
                    ->whereMonth('created_at', $i)->sum('instructor_amount');
            }
            $monthlySales = [
                'labels' => $labels,
                'info' => $info,
                'currency' => getCurrencySymbol(),
            ];
            $message = [
                'title' => ___('instructor.Monthly Sales ,') . date('Y'),
                'type' => ___('instructor.Sales'),
            ];
            return $this->responseWithSuccess($message, $monthlySales, 200); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
