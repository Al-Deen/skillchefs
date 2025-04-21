<?php

namespace Modules\Accounts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Accounts\Interfaces\IncomeInterface;

class IncomeController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $income;

    public function __construct(IncomeInterface $incomeInterface)
    {
        $this->income = $incomeInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['title'] = ___('account.Income List'); // title
            $data['incomes'] = $this->income->model()->search($request)->orderBy('id', 'DESC')->paginate($request->show ?? 10); // data
            return view('accounts::income.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
