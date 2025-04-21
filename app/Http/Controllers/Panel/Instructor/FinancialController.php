<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Exports\EnrollExport;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Instructor\Http\Requests\PayoutRequest;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Instructor\Interfaces\PayoutInterface;
use Modules\Instructor\Repositories\InstructorPaymentMethodRepository;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Payment\Interfaces\PaymentInterface;

class FinancialController extends Controller
{
    use ApiReturnFormatTrait;

    protected $instructor;
    protected $enrollRepository;
    protected $paymentMethodRepository;
    protected $payoutRepository;
    protected $instructorPaymentMethodRepository;

    public function __construct(
        InstructorInterface $instructor,
        EnrollInterface $enrollRepository,
        PaymentInterface $paymentMethodRepository,
        InstructorPaymentMethodRepository $instructorPaymentMethodRepository,
        PayoutInterface $payoutRepository
    ) {
        $this->instructor = $instructor;
        $this->enrollRepository = $enrollRepository;
        $this->payoutRepository = $payoutRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->instructorPaymentMethodRepository = $instructorPaymentMethodRepository;
    }
    public function salesReport()
    {
        try {
            $data['title'] = ___('instructor.Sales Report'); // title
            $data['enrolls'] = $this->enrollRepository->model()->with('orderItem')->where('instructor_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
            return view('panel.instructor.financial.sales_report', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function salesReportDownload()
    {
        try {
            $data['title'] = ___('instructor.Sales Report'); // title
            $enrolls = $this->enrollRepository->model()->with('orderItem')->where('instructor_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
            return Excel::download(new EnrollExport($enrolls), 'sales_report.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // payout request
    public function payoutsList()
    {
        try {
            $data['title'] = ___('instructor.Payouts List'); // title
            $data['instructor'] = $this->instructor->model()->where('user_id', auth()->user()->id)->first();
            $data['payouts'] = $this->payoutRepository->model()->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
            return view('panel.instructor.financial.payouts', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function payoutRequest()
    {

        try {
            $data['instructor'] = $this->instructor->model()->where('user_id', auth()->user()->id)->first();
            if (@$data['instructor']->balance <= 0) {
                return $this->responseWithError(___('alert.you_have_no_balance_to_request'), [], 400); // return error response
            }
            $data['payouts'] = $this->payoutRepository->model()->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
            if (@$data['payouts']->status_id == 3) {
                return $this->responseWithError(___('alert.you_have_already_requested_for_payout'), [], 400); // return error response
            }
            if ($data['instructor']->paymentMethod()->where('is_default', 1)->count() == 0) {
                return $this->responseWithError(___('alert.please_add_payment_method_first'), [], 400); // return error response
            }
            $data['payment_methods'] = $this->instructorPaymentMethodRepository->model()->where('status_id', 1)->get(); // payment methods
            $data['url'] = route('instructor.payout_request.store'); // url
            $data['title'] = ___('instructor.Payout Request'); // title
            @$data['button'] = ___('common.Request'); // button
            $html = view('panel.instructor.modal.payment.payout_request', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function payoutRequestStore(PayoutRequest $request)
    {
        try {
            $instructor = $this->instructor->model()->where('user_id', auth()->user()->id)->first();
            if (@$instructor->balance <= 0) {
                return $this->responseWithError(___('alert.you_have_no_balance_to_request'), [], 400); // return error response
            }
            $result = $this->payoutRepository->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }

        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function payoutDetails($id)
    {
        try {
            $data['title'] = ___('instructor.Payout Details'); // title
            $data['payout'] = $this->payoutRepository->model()->where('user_id', auth()->user()->id)->where('id', $id)->first();
            return view('panel.instructor.financial.payout_details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
