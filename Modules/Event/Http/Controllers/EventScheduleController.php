<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Interfaces\EventScheduleInterface;
use Modules\Event\Http\Requests\Schedule\CreateScheduleRequest;
use Modules\Event\Http\Requests\Schedule\UpdateScheduleRequest;
use Modules\Event\Http\Requests\Schedule\CreateScheduleListRequest;

class EventScheduleController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;
    protected $schedule;
    public function __construct(EventScheduleInterface $schedule)
    {
        $this->schedule = $schedule;
    }

    public function index($id)
    {
        try {
            $data['title'] = ___('event.Schedules'); // title
            $data['schedules'] = $this->schedule->model()->where('event_id', decryptFunction($id))->with('scheduleList')->orderBy('date')->paginate(10);
            return view('event::backend.instructor.event.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create($id)
    {
        try {
            $data['url'] = route('event.instructor.schedule.store', $id); // url
            $data['title'] = ___('event.Create Schedule Date');
            @$data['button'] = ___('event.Add'); // button
            @$data['status'] = DB::table('statuses')->whereIn('id', [1, 2])->get();
            $html = view('event::backend.instructor.modal.schedule.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function store(CreateScheduleRequest $request, $id)
    {
        try {
            $result = $this->schedule->store($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function edit($id)
    {
        try {
            $data['url'] = route('event.instructor.schedule.update', $id); // url
            $data['title'] = ___('event.Update Schedule Date');
            @$data['button'] = ___('event.Update'); // button
            @$data['status'] = DB::table('statuses')->whereIn('id', [1, 2])->get();
            @$data['schedule'] = $this->schedule->model()->where('id', decryptFunction($id))->first();

            $html = view('event::backend.instructor.modal.schedule.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function update(UpdateScheduleRequest $request, $id)
    {
        try {
            $result = $this->schedule->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->schedule->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    // Schedule List
    public function listView($id)
    {
        try {
            $data['title'] = ___('event.Schedule Timeline');
            @$data['status'] = DB::table('statuses')->whereIn('id', [1, 2])->get();
            @$data['schedule-list'] = $this->schedule->scheduleListModel()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.instructor.modal.schedule-list.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function listCreate($id)
    {
        try {
            $data['url'] = route('event.instructor.schedule.list.store', $id); // url
            $data['title'] = ___('event.Create Schedule Timeline');
            @$data['button'] = ___('event.Add'); // button
            @$data['status'] = DB::table('statuses')->whereIn('id', [1, 2])->get();

            $html = view('event::backend.instructor.modal.schedule-list.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function listStore(CreateScheduleListRequest $request, $id)
    {
        try {
            $result = $this->schedule->listStore($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function listEdit($id)
    {
        try {
            $data['url'] = route('event.instructor.schedule.list.update', $id); // url
            $data['title'] = ___('event.Update Schedule Timeline');
            @$data['button'] = ___('event.Update'); // button
            @$data['status'] = DB::table('statuses')->whereIn('id', [1, 2])->get();
            @$data['schedule-list'] = $this->schedule->scheduleListModel()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.instructor.modal.schedule-list.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    // UpdateScheduleListRequest
    public function listUpdate(Request $request, $id)
    {
        try {
            $result = $this->schedule->listUpdate($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function listDestroy($id)
    {
        try {
            $result = $this->schedule->listDestroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
