<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Event\Interfaces\EventInterface;
use Modules\Event\Exports\EventReportExport;

class EventFinancialController extends Controller
{
    use ApiReturnFormatTrait;

    protected $event;

    public function __construct(EventInterface $event) {
        $this->event = $event;
    }

    public function salesReport()
    {
        try {
            $data['title'] = ___('instructor.Sales Report'); // title
            $data['enrolls'] = $this->event->model()->where('created_by', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
            return view('panel.instructor.financial.sales_report', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function salesReportDownload()
    {
        try {
            $data['title'] = ___('instructor.Sales Report'); // title
            $events = $this->event->model()->where('created_by', auth()->user()->id)->orderBy('id', 'DESC')->get();
            return Excel::download(new EventReportExport($events), 'sales_report.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
