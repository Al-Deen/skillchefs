<?php

namespace Modules\Event\Repositories;

use Illuminate\Support\Str;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Entities\EventRegistration;
use Modules\Event\Interfaces\EventRegistrationInterface;
use Carbon\Carbon;

class EventRegistrationRepository implements EventRegistrationInterface
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(EventRegistration $eventRegistrationModel)
    {
        $this->model = $eventRegistrationModel;
    }

    public function all()
    {
        try {
            return $this->model->get();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function model()
    {
        try {
            return $this->model;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function store($request)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $eventRegistrationModel = new $this->model; // create new object of model for store data in database table
            $eventRegistrationModel->user_id = auth()->user()->id;
            $eventRegistrationModel->event_id = $request['event']->id;
            $eventRegistrationModel->price = $request['event']->price;
            $eventRegistrationModel->instructor_commission = ($request['event']->price * ($request['event']->user->instructor_commission / 100));
            $eventRegistrationModel->payment_method = $request['payment_method'] ?? 'free';

            if($request['payment_method'] === 'offline'){
                $manual_info = [
                    'payment_type'       => $request['payment_type'],
                    'additional_details'        => $request['additional_details'],
                ];
                $eventRegistrationModel->payment_manual = $manual_info;
            }

            $eventRegistrationModel->invoice_number = $this->generateInvoiceNumber();
            $eventRegistrationModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Event_registered_successfully.'), $eventRegistrationModel); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function storeFreeEvent($request){
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $eventRegistrationModel = new $this->model; // create new object of model for store data in database table
            $eventRegistrationModel->user_id = auth()->user()->id;
            $eventRegistrationModel->event_id = $request->id;
            $eventRegistrationModel->price = 0.00;
            $eventRegistrationModel->status = "paid";
            $eventRegistrationModel->payment_method = 'free';
            $eventRegistrationModel->invoice_number = $this->generateInvoiceNumber();
            $eventRegistrationModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Event_registered_successfully.'), $eventRegistrationModel); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
