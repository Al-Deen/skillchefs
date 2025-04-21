<?php

namespace Modules\Order\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Order\Interfaces\OrderInterface;

class EnrollController extends Controller
{
    use ApiReturnFormatTrait;

    protected $enrollRepository;
    protected $orderRepository;

    public function __construct(EnrollInterface $enrollRepository, OrderInterface $orderRepository) {
        $this->enrollRepository = $enrollRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Course Enrollment'); // title
            $data['enrolls'] = $this->enrollRepository->model()->with('orderItem')->search($request)->orderBy('id', 'DESC')->paginate(10);
            return view('order::enroll.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function adminInvoice($enroll_id)
    {
        try {
            $data['enroll'] = $this->enrollRepository->model()->where('id', $enroll_id)->first() ;
            if (!$data['enroll']) {
                return redirect()->back()->with('danger', ___('alert.invoice_not_found'));
            }
            $data['title'] = ___('common.Invoice');
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->loadView('panel.instructor.invoice.invoice', compact('data'));
            return $pdf->stream('invoice-'.$data['enroll']->id.time().'.pdf');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function adminPaymentDetail($order_item_id){
        try {
            $data['order_item'] = $this->orderRepository->orderItemModel()->find($order_item_id);
            if (!$data['order_item']) {
                return $this->responseWithError(___('alert.Order_not_found'), [], 400); // return error response
            }
            $data['title'] = ___('common.Payment_Details'); // title
            $data['button'] = ___('common.Discard'); // title
            $html = view('order::enroll.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
