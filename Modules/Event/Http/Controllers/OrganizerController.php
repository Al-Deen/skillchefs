<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Interfaces\EventOrganizerInterface;
use Modules\Event\Http\Requests\Event\CreateOrganizerRequest;
use Modules\Event\Http\Requests\Event\UpdateOrganizerRequest;

class OrganizerController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $organizer;

    public function __construct(EventOrganizerInterface $organizer)
    {
        $this->organizer = $organizer;
    }

    public function index($id)
    {
        try {
            $data['organizers']= $this->organizer->model()->where('event_id', decryptFunction($id))->paginate(10);
            return view('event::backend.instructor.event.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create($id)
    {
        try {
            $data['url'] = route('instructor.event.organizer.store', $id); // url
            $data['title'] = ___('event.Create Organizer');
            @$data['button'] = ___('event.Add'); // button
            $html = view('event::backend.instructor.modal.organizer.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function store(CreateOrganizerRequest $request, $id)
    {
        try {
            $result = $this->organizer->store($request, $id);
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
            $data['url'] = route('instructor.event.organizer.update', decryptFunction($id)); // url
            $data['title'] = ___('event.Update Organizer');
            @$data['button'] = ___('event.Update'); // button
            @$data['organizer'] = $this->organizer->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.instructor.modal.organizer.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function update(UpdateOrganizerRequest $request, $id)
    {
        try {
            $result = $this->organizer->update($request, $id);
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
            $result = $this->organizer->destroy($id);
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
