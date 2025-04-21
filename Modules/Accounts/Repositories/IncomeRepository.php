<?php

namespace Modules\Accounts\Repositories;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Entities\Account;
use Modules\Accounts\Entities\Income;
use Modules\Accounts\Entities\Transaction;
use Modules\Accounts\Interfaces\ExpenseInterface;
use Modules\Accounts\Interfaces\IncomeInterface;

class IncomeRepository implements IncomeInterface
{
    use ApiReturnFormatTrait;

    private $model;
    private $account;
    private $transaction;
    private $expenseRepository;

    public function __construct(Income $incomeModel, Account $accountModel, Transaction $transactionModel, ExpenseInterface $expenseRepository)
    {
        $this->model = $incomeModel;
        $this->account = $accountModel;
        $this->transaction = $transactionModel;
        $this->expenseRepository = $expenseRepository;
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
            $transaction->status_id = 26;
            $transaction->save(); // save data in database table

            $income = new $this->model;
            $income->transaction_id = $transaction->id;
            $income->amount = $data['amount'];
            $income->note = $data['note'];
            $income->status_id = 8;
            $income->save(); // save data in database table
            DB::commit();

            $account->balance = $account->balance + $data['amount'];
            $account->save(); // save data in database table

            return $this->responseWithSuccess(___('alert.Income created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function revenue()
    {
        try {
            // month wise sales
            // 12 months with name  data with 0 value
            $labels = [];
            $income = [];
            $expense = [];

            for ($i = 1; $i <= 12; $i++) {
                $labels[] = date('F', mktime(0, 0, 0, $i, 10));
                $income[] = $this->model->whereMonth('created_at', $i)->sum('amount');
                $expense[] = $this->expenseRepository->model()->whereMonth('created_at', $i)->sum('amount');
            }
            $monthlySales = [
                'labels' => $labels,
                'income' => [
                    'label' => ___('instructor.Income'),
                    'data' => $income,
                ],
                'expense' => [
                    'label' => ___('instructor.Expense'),
                    'data' => $expense,
                ],
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
