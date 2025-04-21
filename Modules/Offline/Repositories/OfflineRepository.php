<?php

namespace Modules\Offline\Repositories;

use App\Enums\Role;
use App\Models\User;
use App\Traits\FileUploadTrait;
use App\Traits\CommonHelperTrait;
use Modules\Order\Entities\Order;
use Modules\Event\Entities\EventRegistration;
use Modules\Subscription\Entities\PackagePurchase;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Enroll;
use App\Traits\ApiReturnFormatTrait;
use Modules\Order\Entities\OrderItem;
use Modules\Offline\Interfaces\OfflineInterface;
use Modules\Accounts\Interfaces\IncomeInterface;

class OfflineRepository implements OfflineInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $enrollModel;
    private $orderModel;
    private $orderItemModel;
    private $eventRegistration;
    private $income;

    public function __construct(Enroll $enrollModel, Order $orderModel, OrderItem $orderItemModel, EventRegistration $eventRegistration, IncomeInterface $incomeRepository)
    {
        $this->enrollModel = $enrollModel;
        $this->orderModel = $orderModel;
        $this->orderItemModel = $orderItemModel;
        $this->eventRegistration = $eventRegistration;
        $this->income = $incomeRepository;
    }


    public function model()
    {
        return $this->enrollModel;
    }

    /* course enrollment approval */
    public function approveCourseEnroll($order_id){
        DB::beginTransaction(); // start database transaction
        try {
            $order = $this->orderModel->where('id', $order_id)->first();
            foreach ($this->orderItemModel->where('order_id', $order_id)->get() as $order_item) {
                $enrollModel = new $this->enrollModel;
                $enrollModel->order_item_id = $order_item->id;
                $enrollModel->course_id = $order_item->course_id;
                $enrollModel->user_id = $order->user_id;
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
                $order->update([
                    'status' => 'paid',
                ]);
            }
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course enroll approved successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroyCourseApproval($id){
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $target = $this->orderModel->find(decryptFunction($id));
            $target->delete();
            return $this->responseWithSuccess(___('event.Order deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    /* course enrollment approval end*/

     /* event registration approval*/
    public function approveEventRegistration($id){
        DB::beginTransaction(); // start database transaction
        try {
            $this->eventRegistration->where('id', $id)->update([
                'status' => 'paid',
            ]);
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Event registration approved successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroyEventApproval($id){
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $target = $this->eventRegistration->find(decryptFunction($id));
            $target->delete();
            return $this->responseWithSuccess(___('event.Event deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }


    /* event registration approval end*/

     /* package enrollment approval*/
    public function approvePackageEnroll($id){
        DB::beginTransaction(); // start database transaction
        try {
            \Modules\Subscription\Entities\PackagePurchase::where('id', $id)->update([
                'status' => 'paid',
            ]);
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Package enroll approved successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroyPackageApproval($id){
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $target =  \Modules\Subscription\Entities\PackagePurchase::find(decryptFunction($id));
            $target->delete();
            return $this->responseWithSuccess(___('event.Package enroll deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    /* package enrollment approval end*/
}
