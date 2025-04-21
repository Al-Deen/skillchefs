<?php

namespace Modules\Accounts\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Http\Requests\AccountRequest;
use Modules\Accounts\Interfaces\AccountInterface;

class AccountController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $account;

    public function __construct(AccountInterface $accountInterface)
    {
        $this->account = $accountInterface;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['title'] = ___('account.Account List'); // title
            $data['accounts'] = $this->account->model()->search($request)->orderBy('id', 'DESC')->paginate($request->show ?? 10); // data
            return view('accounts::account.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function transactionList(Request $request)
    {
        try {
            $data['title'] = ___('account.Transaction List'); // title
            $data['transactions'] = $this->account->transactionModel()->search($request)->orderBy('id', 'DESC')->paginate($request->show ?? 10); // data
            return view('accounts::transaction.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['url'] = route('admin.accounts.store'); // url
            $data['title'] = ___('account.Account Create'); // title
            @$data['button'] = ___('common.Save');
            $html = view('accounts::account.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AccountRequest $request)
    {
        try {
            $result = $this->account->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message']); // return success response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['account'] = $this->account->model()->find($id); // data
            if (!$data['account']) {
                return $this->responseWithError(___('alert.account_not_found'), [], 400); // return error response
            }
            $data['url'] = route('admin.accounts.update', $id); // url
            $data['title'] = ___('account.Account Update'); // title
            @$data['button'] = ___('common.Update');
            $html = view('accounts::account.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AccountRequest $request, $id)
    {
        try {
            $result = $this->account->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message']); // return success response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $result = $this->account->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return danger response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
