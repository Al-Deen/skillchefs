<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\CommonHelperTrait;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Interfaces\EventRegistrationInterface;

class StudentEventController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $eventRegistration;

    public function __construct(EventRegistrationInterface $eventRegistration)
    {
        $this->eventRegistration = $eventRegistration;
    }

    public function index(Request $request)
    {
        try {
            $data['title'] = ___('event.My Events'); // title
            $data['event_registration'] = $this->eventRegistration->model()->where('status', '!=', 'failed')->where('user_id', auth()->user()->id)->search($request)->paginate(10);
            return view('event::backend.student.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function details($id){
        try {
            $data['title'] = ___('event.Event Details');
            @$data['event_registration'] = $this->eventRegistration->model()->where('id', decryptFunction($id))->first();
            $html = view('event::backend.student.modal.registered_event_view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
