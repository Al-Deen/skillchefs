<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Event\Exports\EventBookingExport;
use App\Traits\ApiReturnFormatTrait;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Event\Interfaces\EventInterface;

class EventReportController extends Controller
{
    use ApiReturnFormatTrait;
    protected $eventInterface;

    // constructor injection
    public function __construct(EventInterface $eventInterface) {
        $this->eventInterface = $eventInterface;
    }

    public function eventBookingIndex(Request $request)
    {
        try {
            $data['events'] = $this->eventInterface->model()->search($request)->orderBy('id', 'DESC')->paginate(10);
            $data['title'] = ___('report.Event_Booking_Report'); // title
            return view('event::backend.admin.report.event_booking', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function eventBookingExport(Request $request)
    {
        try {
            $event_booking = $this->eventInterface->model()->get();
            return Excel::download(new EventBookingExport($event_booking), 'event-booking-export.csv');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
