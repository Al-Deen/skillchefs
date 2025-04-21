<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Modules\Event\Interfaces\EventInterface;
use Modules\Event\Http\Requests\Event\CreateEventRequest;
use Modules\Event\Http\Requests\Event\UpdateEventRequest;
use Modules\Event\Interfaces\EventRegistrationInterface;
use Modules\Event\Interfaces\EventCategoryInterface;
use Modules\Event\Interfaces\EventSpeakerInterface;
use Modules\Event\Interfaces\EventOrganizerInterface;
use Modules\Event\Interfaces\EventScheduleInterface;
use Modules\Event\Http\Requests\Event\CreateSpeakerRequest;
use Modules\Event\Http\Requests\Event\CreateOrganizerRequest;
use Modules\Event\Http\Requests\Event\UpdateOrganizerRequest;
use Modules\Event\Http\Requests\Schedule\CreateScheduleRequest;
use Modules\Event\Http\Requests\Schedule\UpdateScheduleRequest;
use Modules\Event\Http\Requests\Schedule\CreateScheduleListRequest;

class EventAdminController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;
    // constructor injection
    protected $event;
    protected $eventRegistration;
    protected $eventCategory;
    protected $eventSpeaker;
    protected $eventOrganizer;
    protected $eventSchedule;

    public function __construct(EventInterface $event, EventRegistrationInterface $eventRegistration, EventCategoryInterface $eventCategory,
        EventSpeakerInterface $eventSpeaker, EventOrganizerInterface $eventOrganizer, EventScheduleInterface $eventSchedule)
    {
        $this->event = $event;
        $this->eventRegistration = $eventRegistration;
        $this->eventCategory = $eventCategory;
        $this->eventSpeaker = $eventSpeaker;
        $this->eventOrganizer = $eventOrganizer;
        $this->eventSchedule = $eventSchedule;
    }

    public function requestedIndex(Request $request)
    {
        try {
            $data['title'] = ___('event.Requested Event'); // title
            $data['tableHeader'] = $this->event->tableHeader(); // table header
            $data['event'] = $this->event->model()->search($request)->pending()->paginate($request->show ?? 10); // data
            return view('event::backend.admin.event.requested', compact('data')); // view
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function approvedIndex(Request $request)
    {
        try {
            $data['title'] = ___('event.Approved Event'); // title
            $data['tableHeader'] = $this->event->tableHeader(); // table header
            $data['event'] = $this->event->model()->search($request)->approved()->paginate($request->show ?? 10); // data
            return view('event::backend.admin.event.index', compact('data')); // view
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function rejectedIndex(Request $request)
    {
        try {
            $data['title'] = ___('event.Rejected Event'); // title
            $data['tableHeader'] = $this->event->tableHeader(); // table header
            $data['event'] = $this->event->model()->search($request)->rejected()->paginate($request->show ?? 10); // data
            return view('event::backend.admin.event.rejected', compact('data')); // view
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function approve($event_id)
    {
        try {
            $event = $this->event->model()->where('id', $event_id)->first(); // data
            if (!$event) {
                return redirect()->back()->with('danger', ___('alert.event_not_found'));
            }
            $result = $this->event->approve($event_id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function reject($event_id)
    {
        try {
            $event = $this->event->model()->where('id', $event_id)->first(); // data
            if (!$event) {
                return redirect()->back()->with('danger', ___('alert.event_not_found'));
            }
            $result = $this->event->reject($event_id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function purchaseBookingIndex(Request $request){
        try {
            $data['title'] = ___('event.Sale Events'); // title
            $data['tableHeader'] = $this->event->tableHeader(); // table header
            $data['event'] = $this->event->model()->search($request)->paginate($request->show ?? 10); // data
            return view('event::backend.admin.event.purchase_booking', compact('data')); // view
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create()
    {
        try {
            $data['title'] = ___('event.Create Event'); // title
            $data['button'] = ___('common.create'); // button
            $data['categories'] = $this->eventCategory->model()->get();
            $data['event_type'] = ['Online', 'Offline'];
            $data['show_participant'] = DB::table('statuses')->whereIn('id', [22, 23])->get();
            $data['is_paid'] = DB::table('statuses')->whereIn('id', [10, 11])->get();
            return view('event::backend.admin.event.create', compact('data')); // view
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function store(CreateEventRequest $request)
    {
        try {
            $result = $this->event->store($request);
            if($result->original['data']){
                $this->event->approve($result->original['data']);
            }
            if ($result->original['result']) {
                return redirect()->route('event.admin.approved_event')->with('success', $result->original['message']);
            } else {
                return redirect()->route('event.admin.approved_event')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function edit($id)
    {
        try {
            $data['title'] = ___('event.Edit Event'); // title
            $data['button'] = ___('common.update'); // button
            $data['url'] = route('event.admin.update', encryptFunction($id)); // url
            $data['event'] = $this->event->model()->where('id', $id)->first();
            $data['categories'] = $this->eventCategory->model()->get();
            $data['event_type'] = ['Online', 'Offline'];
            $data['show_participant'] = DB::table('statuses')->whereIn('id', [22, 23])->get();
            $data['is_paid'] = DB::table('statuses')->whereIn('id', [10, 11])->get();
            return view('event::backend.admin.event.edit', compact('data'));
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function update(UpdateEventRequest $request, $id)
    {
        try {
            $result = $this->event->update($request, $id);
            $this->event->approve(decryptFunction($id));
            if ($result->original['result']) {
                return redirect()->route('event.admin.approved_event')->with('success', $result->original['message']);
            } else {
                return redirect()->route('event.admin.approved_event')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->event->destroy($id);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /* event speakers */
    public function speakerTab($id)
    {
        try {
            $data['title'] = ___('event.Edit Event'); // title
            $data['speaker'] = $this->eventSpeaker->model()->where('event_id', $id)->paginate(10);
            $data['event'] = $this->event->model()->where('id', $id)->first();
            return view('event::backend.admin.event.edit', compact('data'));
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function createSpeaker($id){
        try {
            $data['url'] = route('event.admin.speaker.store', $id); // url
            $data['title'] = ___('event.Create Speaker');
            @$data['button'] = ___('event.Submit'); // button
            $html = view('event::backend.admin.modal.speaker.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeSpeaker(CreateSpeakerRequest $request, $id){
        try {
            $result = $this->eventSpeaker->store($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function editSpeaker($id){
        try {
            $data['url'] = route('event.admin.speaker.update', decryptFunction($id)); // url
            $data['title'] = ___('event.Update Speaker');
            @$data['button'] = ___('event.Update'); // button
            @$data['speaker'] = $this->eventSpeaker->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.admin.modal.speaker.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updateSpeaker(CreateSpeakerRequest $request, $id){
        try {
            $result = $this->eventSpeaker->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function destroySpeaker($id){
        try {
            $result = $this->eventSpeaker->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    /* event speakers end */
    /* event organizer */
    public function organizerTab($id)
    {
        try {
            $data['title'] = ___('event.Edit Event'); // title
            $data['organizer'] = $this->eventOrganizer->model()->where('event_id', $id)->paginate(10);
            $data['event'] = $this->event->model()->where('id', $id)->first();
            return view('event::backend.admin.event.edit', compact('data'));
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function createOrganizer($id){
        try {
            $data['url'] = route('event.admin.organizer.store', $id); // url
            $data['title'] = ___('event.Create Organizer');
            @$data['button'] = ___('event.Submit'); // button
            $html = view('event::backend.admin.modal.organizer.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeOrganizer(CreateOrganizerRequest $request, $id){
        try {
            $result = $this->eventOrganizer->store($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function editOrganizer($id){
        try {
            $data['url'] = route('event.admin.organizer.update', decryptFunction($id)); // url
            $data['title'] = ___('event.Update Organizer');
            @$data['button'] = ___('event.Update'); // button
            @$data['organizer'] = $this->eventOrganizer->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.admin.modal.organizer.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updateOrganizer(UpdateOrganizerRequest $request, $id){
        try {
            $result = $this->eventOrganizer->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function destroyOrganizer($id){
        try {
            $result = $this->eventOrganizer->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    /* event organizer end */
    /* event schedule */
    public function scheduleTab($id)
    {
        try {
            $data['title'] = ___('event.Edit Event'); // title
            $data['schedule'] = $this->eventSchedule->model()->where('event_id', $id)->with('scheduleList')->orderBy('date')->paginate(10);
            $data['event'] = $this->event->model()->where('id', $id)->first();
            return view('event::backend.admin.event.edit', compact('data'));
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function createSchedule($id){
        try {
            $data['url'] = route('event.admin.schedule.store', $id); // url
            $data['title'] = ___('event.Create Schedule Date');
            @$data['button'] = ___('event.Add'); // button
            $html = view('event::backend.admin.modal.schedule.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeSchedule(CreateScheduleRequest $request, $id){
        try {
            $result = $this->eventSchedule->store($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function editSchedule($id){
        try {
            $data['url'] = route('event.admin.schedule.update', $id); // url
            $data['title'] = ___('event.Update Schedule Date');
            @$data['button'] = ___('event.Update'); // button
            @$data['schedule'] = $this->eventSchedule->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.admin.modal.schedule.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updateSchedule(UpdateScheduleRequest $request, $id){
        try {
            $result = $this->eventSchedule->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function destroySchedule($id){
        try {
            $result = $this->eventSchedule->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
     /* event schedule end */
     /* event schedule timeline */
    public function scheduleTimelineTab($id)
    {
        try {
            $data['title'] = ___('event.Edit Event'); // title
            $data['schedule_timeline'] = $this->eventSchedule->scheduleListModel()->where('event_schedule_id', $id)->paginate(10);
            $data['event_schedule'] = $this->eventSchedule->model()->where('id', $id)->first();
            $data['event'] = $this->event->model()->where('id',  $data['event_schedule']->event_id)->first();
            return view('event::backend.admin.event.edit', compact('data'));
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function createScheduleTimeline($id){
        try {
            $data['url'] = route('event.admin.schedules_timeline.store', $id); // url
            $data['title'] = ___('event.Create Schedule Timeline');
            @$data['button'] = ___('event.Add'); // button
            $html = view('event::backend.admin.modal.schedule_timeline.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeScheduleTimeline(CreateScheduleListRequest $request, $id){
        try {
            $result = $this->eventSchedule->listStore($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function editScheduleTimeline($id){
        try {
            $data['url'] = route('event.admin.schedules_timeline.update', $id); // url
            $data['title'] = ___('event.Update Schedule Timeline');
            @$data['button'] = ___('event.Update'); // button
            @$data['schedule_timeline'] = $this->eventSchedule->scheduleListModel()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.admin.modal.schedule_timeline.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function updateScheduleTimeline(CreateScheduleListRequest $request, $id){
        try {
            $result = $this->eventSchedule->listUpdate($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function destroyScheduleTimeline($id){
        try {
            $result = $this->eventSchedule->listDestroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
     /* event schedule timeline end */

    /* participants index */
     public function participantsIndex(Request $request, $id){
        try {
            $data['title'] = ___('event.Event Participants'); // title
            $data['tableHeader'] = $this->event->tableHeader(); // table header
            $data['event_registration'] = $this->eventRegistration->model()->where('event_id', decryptFunction($id))->search($request)->paginate($request->show ?? 10); // data
            return view('event::backend.admin.event.participants', compact('data')); // view
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /* participants invoice */
    public function participantsInvoice(Request $request, $id){
        try {
            $data['event_purchase'] = $this->eventRegistration->model()->where('id', decryptFunction($id))->first();
            if (!$data['event_purchase']) {
                return redirect()->back()->with('danger', ___('alert.Invoice_not_found'));
            }
            $data['title'] = ___('common.Event_Invoice');
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->loadView('event::backend.admin.invoice.event_invoice', compact('data'));
            return $pdf->stream('invoice-'.$data['event_purchase']->id.time().'.pdf');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
