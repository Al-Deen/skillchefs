<?php

namespace Modules\Accounts\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Interfaces\ExpenseInterface;

class ExpenseController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $expense;

    public function __construct(ExpenseInterface $expenseInterface)
    {
        $this->expense = $expenseInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['title'] = ___('account.Expense List'); // title
            $data['expenses'] = $this->expense->model()->search($request)->orderBy('id', 'DESC')->paginate($request->show ?? 10); // data
            return view('accounts::expense.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
