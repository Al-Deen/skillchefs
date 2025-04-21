<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Interfaces\EventSpeakerInterface;
use Modules\Event\Http\Requests\Event\CreateSpeakerRequest;

class SpeakerController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $speaker;

    public function __construct(EventSpeakerInterface $speaker)
    {
        $this->speaker = $speaker;
    }

    public function index($id)
    {
        try {
            $data['title'] = ___('event.Edit Event'); // title
            $data['speakers']= $this->speaker->model()->where('event_id', decryptFunction($id))->paginate(10);
            return view('event::backend.instructor.event.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create($id)
    {
        try {
            $data['url'] = route('instructor.event.speaker.store', $id); // url
            $data['title'] = ___('event.Create Speaker');
            @$data['button'] = ___('event.Add'); // button
            $html = view('event::backend.instructor.modal.speaker.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function store(CreateSpeakerRequest $request, $id)
    {
        try {
            $result = $this->speaker->store($request, $id);
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
            $data['url'] = route('instructor.event.speaker.update', decryptFunction($id)); // url
            $data['title'] = ___('event.Update Speaker');
            @$data['button'] = ___('event.Update'); // button
            @$data['speaker'] = $this->speaker->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.instructor.modal.speaker.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function update(CreateSpeakerRequest $request, $id)
    {
        try {
            $result = $this->speaker->update($request, $id);
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
            $result = $this->speaker->destroy($id);
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
