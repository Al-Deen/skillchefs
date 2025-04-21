<?php

namespace Modules\Instructor\Repositories;

use App\Events\PayoutRejectEvent;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Instructor\Entities\Payout;
use Modules\Instructor\Entities\PayoutLog;
use Modules\Instructor\Interfaces\PayoutInterface;

class PayoutRepository implements PayoutInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $payoutLogModel;

    public function __construct(Payout $payoutModel, Course $courseModel, User $userModel, PayoutLog $payoutLogModel)
    {
        $this->model = $payoutModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->payoutLogModel = $payoutLogModel;
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

    public function logCreate($data)
    {
        $payoutLog = $this->payoutLogModel;
        $payoutLog->payout_id = $data['payout_id'];
        $payoutLog->status_id = $data['status_id'];
        $payoutLog->description = $data['description'];
        $payoutLog->user_id = auth()->user()->id;
        $payoutLog->save();
    }

    public function store($data)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $payoutModel = $this->model;
            $payoutModel->user_id = auth()->user()->id;
            $payoutModel->amount = $data->amount;
            $payoutModel->instructor_payment_method_id = $data->payment_method;
            $payoutModel->save();

            $this->logCreate([
                'payout_id' => $payoutModel->id,
                'status_id' => 3,
                'description' => $data->note,
            ]);

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Payout request sent successfully.'));
        } catch (\Throwable $th) {

            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $payoutModel = $this->model->find($id);
            if (!$payoutModel) {
                return $this->responseWithError(___('alert.Payout not found.'), [], 400);
            }
            $payoutModel->status_id = 4;
            $payoutModel->save();

            $this->logCreate([
                'payout_id' => $payoutModel->id,
                'status_id' => 4,
                'description' => ___('alert.Payout approved successfully.'),
            ]);

            DB::commit();
            return $this->responseWithSuccess(___('alert.Payout approved successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function reject($request, $id)
    {
        DB::beginTransaction();
        try {
            $payout = $this->model->find($id);
            if (!$payout) {
                return $this->responseWithError(___('alert.Payout not found.'), [], 400);
            }
            $payout->status_id = 6;
            $payout->save();

            $this->logCreate([
                'payout_id' => $payout->id,
                'status_id' => 6,
                'description' => $request->rejection_note,
            ]);

            event(new PayoutRejectEvent($payout));
            DB::commit();
            return $this->responseWithSuccess(___('alert.Payout rejected successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
