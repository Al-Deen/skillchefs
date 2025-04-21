<?php

namespace Modules\Instructor\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Instructor\Http\Requests\PayoutRejectRequest;
use Modules\Instructor\Interfaces\PayoutInterface;

class PayoutController extends Controller
{
    use ApiReturnFormatTrait;

    protected $payoutRepository;

    public function __construct(
        PayoutInterface $payoutRepository
    ) {
        $this->payoutRepository = $payoutRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Payouts List'); // title
            $data['payouts'] = $this->payoutRepository->model()->where('status_id', 4)->search($request)->orderBy('id', 'DESC')->paginate(10);
            return view('instructor::payouts.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function requests(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Request Payouts List'); // title
            $data['payouts'] = $this->payoutRepository->model()->where('status_id', 3)->search($request)->orderBy('id', 'DESC')->paginate(10);
            return view('instructor::payouts.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function unpaid(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Unpaid Payouts List'); // title
            $data['payouts'] = $this->payoutRepository->model()->where('status_id', 4)->where('payment_status_id', 9)->search($request)->orderBy('id', 'DESC')->paginate(10);
            return view('instructor::payouts.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function rejected(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Rejected Payouts List'); // title
            $data['payouts'] = $this->payoutRepository->model()->where('status_id', 6)->search($request)->orderBy('id', 'DESC')->paginate(10);
            return view('instructor::payouts.rejected', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function approve($id)
    {
        try {
            $payout = $this->payoutRepository->model()->find($id);
            if (!$payout) {
                return redirect()->back()->with('danger', ___('alert.payout_not_found'));
            }
            $result = $this->payoutRepository->approve($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function reject($id)
    {

        try {
            $data['payout'] = $this->payoutRepository->model()->find($id); // data
            if (!$data['payout']) {
                return $this->responseWithError(___('alert.payout_not_found'), [], 400); // return error response
            }
            $data['url'] = route('admin.instructor.payout.reject.make', $id); // url
            $data['title'] = ___('instructor.Reject Payout'); // title
            @$data['button'] = ___('common.Submit');
            $html = view('instructor::modal.payout.reject', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function makeRejectPayout(PayoutRejectRequest $request, $id)
    {
        try {
            $payout = $this->payoutRepository->model()->find($id);
            if (!$payout) {
                return $this->responseWithError(___('alert.payout_not_found'), [], 400); // return error response
            }
            $result = $this->payoutRepository->reject($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function details($id)
    {
        try {
            $data['payout'] = $this->payoutRepository->model()->find($id); // data
            if (!$data['payout']) {
                return redirect()->back()->with('danger', ___('alert.payout_not_found'));
            }
            $data['title'] = ___('instructor.Payout Details'); // title
            return view('instructor::payouts.details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
