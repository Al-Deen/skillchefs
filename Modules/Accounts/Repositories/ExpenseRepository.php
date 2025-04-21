<?php

namespace Modules\Accounts\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Entities\Account;
use Modules\Accounts\Entities\Expense;
use Modules\Accounts\Entities\Transaction;
use Modules\Accounts\Interfaces\ExpenseInterface;

class ExpenseRepository implements ExpenseInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $account;
    private $transaction;

    public function __construct(Expense $expenseModel, Account $accountModel, Transaction $transactionModel)
    {
        $this->model = $expenseModel;
        $this->account = $accountModel;
        $this->transaction = $transactionModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($data)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $account = $this->account->where('is_default', 1)->first();
            $transaction = new $this->transaction;
            $transaction->account_id = $account->id;
            $transaction->amount = $data['amount'];
            $transaction->user_id = auth()->user()->id;
            $transaction->status_id = 27;
            $transaction->save(); // save data in database table

            $income = new $this->model;
            $income->transaction_id = $transaction->id;
            $income->amount = $data['amount'];
            $income->note = $data['note'];
            $income->status_id = 8;
            $income->save(); // save data in database table

            $account->balance = $account->balance - $data['amount'];
            $account->save(); // save data in database table
            
            DB::commit();
            return $this->responseWithSuccess(___('alert.Expense created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
