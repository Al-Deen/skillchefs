<?php

namespace Modules\Event\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Interfaces\EventInterface;
use Modules\Event\Interfaces\EventRegistrationInterface;
use Modules\Event\Http\Requests\Event\CreateEventRequest;
use Modules\Event\Http\Requests\Event\UpdateEventRequest;
use Modules\Event\Interfaces\EventCategoryInterface;

class EventController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait, FileUploadTrait;
    // constructor injection
    protected $event;
    protected $eventCategory;
    protected $eventRegistration;

    public function __construct(EventInterface $event, EventRegistrationInterface $eventRegistration, EventCategoryInterface $eventCategory)
    {
        $this->event = $event;
        $this->eventCategory = $eventCategory;
        $this->eventRegistration = $eventRegistration;
    }

    public function index(Request $request)
    {
        try {
            $data['title'] = ___('event.My Events'); // title
            $data['events'] = $this->event->model()->search($request)->where('created_by', auth()->user()->id)->paginate(10);
            return view('event::backend.instructor.event.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create()
    {
        $data['title'] = ___('event.Create Event'); // title
        $data['categories'] = $this->eventCategory->model()->get();
        $data['event_type'] = ['Online', 'Offline'];
        $data['show_participant'] = DB::table('statuses')->whereIn('id', [22, 23])->get();
        $data['is_paid'] = DB::table('statuses')->whereIn('id', [10, 11])->get();

        return view('event::backend.instructor.event.create', compact('data'));
    }

    public function store(CreateEventRequest $request)
    {
        try {
            $result = $this->event->store($request);
            if ($result->original['result']) {
                return redirect()->route('instructor.event.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('instructor.event.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function edit($id)
    {
        $data['title'] = ___('event.Edit Event'); // title
        $data['event'] = $this->event->model()->where('id', decryptFunction($id))->first();
        $data['categories'] = $this->eventCategory->model()->get();
        $data['event_type'] = ['Online', 'Offline'];
        $data['show_participant'] = DB::table('statuses')->whereIn('id', [22, 23])->get();
        $data['is_paid'] = DB::table('statuses')->whereIn('id', [10, 11])->get();
        return view('event::backend.instructor.event.edit', compact('data'));
    }


    public function update(UpdateEventRequest $request, $id)
    {
        try {
            $result = $this->event->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('instructor.event.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('instructor.event.index')->with('danger', $result->original['message']);
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
                return redirect()->route('instructor.event.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function registered(Request $request)
    {
        try {
            $data['title'] = ___('event.Registered Events'); // title
            $data['event_registration'] = $this->eventRegistration->model()->where('user_id', auth()->user()->id)->search($request)->paginate(10);
            return view('event::backend.instructor.event.registered_event', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function registeredDetails($id)
    {
        try {
            $data['title'] = ___('event.Registered Event Details');
            @$data['event_registration'] = $this->eventRegistration->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.instructor.modal.registered_event_view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
