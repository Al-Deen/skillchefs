<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Order\Interfaces\EnrollInterface;

class InvoiceController extends Controller
{
    use ApiReturnFormatTrait;
    // constructor injection
    protected $enrollInterface;

    public function __construct(
        EnrollInterface $enrollInterface
    ) {
        $this->enrollInterface = $enrollInterface;
    }

    public function instructorView($enroll_id)
    {
        try {
            $data['enroll'] = $this->enrollInterface->model()->where('id', $enroll_id)->where('instructor_id', auth()->id())->first() ;
            if (!$data['enroll']) {
                return redirect()->back()->with('danger', ___('alert.invoice_not_found'));
            }
            $data['title'] = ___('common.Invoice');
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->loadView('panel.instructor.invoice.invoice', compact('data'));
            return $pdf->stream('invoice-'.$data['enroll']->id.time().'.pdf');
            return view('panel.instructor.invoice.invoice',compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
