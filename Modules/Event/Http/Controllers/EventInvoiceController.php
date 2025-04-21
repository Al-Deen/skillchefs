<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Modules\Event\Interfaces\EventInterface;
use Modules\Event\Interfaces\EventRegistrationInterface;

class EventInvoiceController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $event;
    protected $eventRegistration;

    public function __construct(EventInterface $event, EventRegistrationInterface $eventRegistration)
    {
        $this->event = $event;
        $this->eventRegistration = $eventRegistration;
    }

    public function instructorInvoice($id)
    {
        try {
            $data['event_registration'] = $this->eventRegistration->model()->where('id', decryptFunction($id))->first();
            if (!$data['event_registration']) {
                return redirect()->back()->with('danger', ___('alert.invoice_not_found'));
            }
            $data['title'] = ___('common.Event Invoice');
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->loadView('event::backend.instructor.invoice.invoice', compact('data'));
            return $pdf->stream('invoice-'.$data['event_registration']->id.time().'.pdf');
            return view('event::backend.instructor.invoice.invoice',compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function studentInvoice($id)
    {
        try {
            $data['event_registration'] = $this->eventRegistration->model()->where('id', decryptFunction($id))->first();
            if (!$data['event_registration']) {
                return redirect()->back()->with('danger', ___('alert.invoice_not_found'));
            }
            $data['title'] = ___('common.Event Invoice');
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->loadView('event::backend.student.invoice.invoice', compact('data'));
            return $pdf->stream('invoice-'.$data['event_registration']->id.time().'.pdf');
            return view('event::backend.student.invoice.invoice',compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
