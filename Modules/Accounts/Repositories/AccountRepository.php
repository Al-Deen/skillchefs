<?php

namespace Modules\Accounts\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Entities\Account;
use Modules\Accounts\Entities\Transaction;
use Modules\Accounts\Interfaces\AccountInterface;

class AccountRepository implements AccountInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $transaction;

    public function __construct(Account $accountModel, Transaction $transactionModel)
    {
        $this->model = $accountModel;
        $this->transaction = $transactionModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($request)
    {
        DB::beginTransaction(); // start database transaction
        try {

            $account = new $this->model;
            $account->name = $request->name;
            $account->ac_name = $request->ac_name;
            $account->ac_number = $request->ac_number;
            $account->code = $request->code;
            $account->status_id = $request->status_id;
            if (@$request->is_default && @$request->is_default == 1) {
                $this->model->where('is_default', 1)->update(['is_default' => 10]);
                $account->is_default = $request->is_default;
            } else {
                if ($this->model->where('is_default', 1)->count() == 0) {
                    return $this->responseWithError(___('alert.Please_select_default_account'), [], 400);
                }
                $account->is_default = 0;
            }
            $account->branch = $request->branch;
            $account->balance = $request->balance ?? 0;
            $account->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Account created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $account = $this->model->find($id);
            if (!$account) {
                return $this->responseWithError(___('alert.Account not found'), [], 400);
            }

            $account->name = $request->name;
            $account->ac_name = $request->ac_name;
            $account->ac_number = $request->ac_number;
            $account->code = $request->code;
            $account->status_id = $request->status_id;
            if (@$request->is_default && @$request->is_default == 1) {
                $this->model->where('id', '!=', $account->id)->where('is_default', 1)->update(['is_default' => 0]);
                $account->is_default = 1;
            } else {
                if ($this->model->where('id', '!=', $account->id)->where('is_default', 1)->count() == 0) {
                    return $this->responseWithError(___('alert.Please_select_default_account'), [], 400);
                }
                $account->is_default = 0;
            }
            $account->branch = $request->branch;
            $account->balance = $request->balance;
            $account->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Account  updated successfully.'));
        } catch (\Throwable $th) {

            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $sectionModel = $this->model->find($id);
            if (!$sectionModel) {
                return $this->responseWithError(___('alert.course_not_found'), [], 400); // return error response
            }
            $sectionModel->delete();
            return $this->responseWithSuccess(___('alert.Account deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function transactionModel()
    {
        return $this->transaction;
    }
}
