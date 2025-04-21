<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MakePayoutEvent;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Modules\Payment\Interfaces\PaymentInterface;
use Modules\Accounts\Interfaces\ExpenseInterface;
use Modules\Instructor\Interfaces\PayoutInterface;

class PaymentController extends Controller
{

    use ApiReturnFormatTrait;

    protected $payoutRepository;
    protected $paymentRepository;
    protected $expenseRepository;

    public function __construct(
        PayoutInterface $payoutRepository,
        PaymentInterface $paymentRepository,
        ExpenseInterface $expenseRepository
    ) {
        $this->payoutRepository = $payoutRepository;
        $this->paymentRepository = $paymentRepository;
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('instructor::index');
    }

    public function payment(Request $request, $id)
    {
        try {
            $payout = $this->payoutRepository->model()->find($id);
            if (!$payout) {
                return $this->responseWithError(___('alert.payout_not_found'), [], 400); // return error response
            }
            $data['payment_method'] = @$payout->instructorPaymentMethod->paymentMethod->name;
            $data['country'] = setting('country') ? setting('country') : 'Bangladesh';

            session()->put('payout_id', $payout->id);

            $payment = $this->paymentRepository->findAdminPaymentMethod($data['payment_method']);
            $redirect = $payment->process($payout);
            if (in_array($data['payment_method'], $this->paymentRepository->withoutRedirect())) {
                return $redirect;
            }
            return Redirect::away($redirect);

        } catch (\Throwable $th) {
            return redirect()->route('admin.instructor.payout.unpaid')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function verify(Request $request, $gateway)
    {

        $payment_method = $this->paymentRepository->model()->where('name', $gateway)->first();

        try {
            if (@$request->get('status') == 'cancel') {
                return redirect()->route('admin.instructor.payout.unpaid')->with('danger', ___('alert.Cancelled_payment'));
            } elseif (@$request->get('status') == 'fail') {
                return redirect()->route('admin.instructor.payout.unpaid')->with('danger', ___('alert.Failed_payment'));
            }
            $payment = $this->paymentRepository->findAdminPaymentMethod($payment_method->name);
            $payout = $payment->verify($request);
            if (@$payout) {
                $this->payoutRepository->logCreate([
                    'payout_id' => $payout->id,
                    'status_id' => 8,
                    'description' => ___('alert.Payment success'),
                ]);
                $this->expenseRepository->store([
                    'amount' => $payout->amount,
                    'note' => ___('common.Instructor Payout'),
                ]);
                event(new MakePayoutEvent($payout));
                session()->put('payout_id', $payout->id);
                return redirect()->route('admin.payment.status');
            } else {
                return redirect()->route('admin.instructor.payout.unpaid')->with('danger', ___('alert.Payment gateway error'));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.instructor.payout.unpaid')->with('danger', ___('alert.Payment gateway error'));
        }
    }

    public function status(Request $request)
    {
        try {
            $payout_id = $request->get('payout_id', null);
            if (!empty(session()->get('payout_id', null))) {
                $payout_id = session()->get('payout_id', null);
                session()->forget('payout_id');
                session()->forget('cart');
                session()->forget('total_price');
                session()->forget('discount');
            }
            return redirect()->route('admin.instructor.payout.index')->with('success', ___('alert.Payment successfully completed'));
        } catch (\Throwable $th) {
            return redirect()->route('admin.instructor.payout.unpaid')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('instructor::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('instructor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('instructor::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
