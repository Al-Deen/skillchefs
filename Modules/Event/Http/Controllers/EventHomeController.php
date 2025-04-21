<?php

namespace Modules\Event\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Event\Entities\Event;
use Modules\Event\Interfaces\EventCategoryInterface;
use Modules\Event\Interfaces\EventInterface;

class EventHomeController extends Controller
{

    use ApiReturnFormatTrait;
    // constructor injection
    protected $event;
    protected $eventCategory;

    public function __construct(EventInterface $event, EventCategoryInterface $eventCategory)
    {
        $this->event = $event;
        $this->eventCategory = $eventCategory;
    }

    public function show($slug)
    {
        try {
            $data['title'] = ___('event.Event');
            $events = Event::where('status_id', 3)->get(); //############################ Update 3 to 1
            $data['events'] = $events->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'title' => $item->title,
                    'event_type' => $item->event_type,
                    'is_paid' => $item->isPaid(),
                    'slug' => $item->slug,
                    'start' => Carbon::createFromFormat('Y-m-d H:i:s', $item->start),
                ];
            });

            $data['event'] = Event::where('slug', $slug)->with('activeSchedule', 'speaker', 'organizer')->first();
            if (!$data['event']) {
                return redirect()->back()->with('error', ___('alert.something_went_wrong_please_try_again'));
            }
            $data['event']->start = Carbon::createFromFormat('Y-m-d H:i:s', $data['event']->start);
            $data['event']->end = Carbon::createFromFormat('Y-m-d H:i:s', $data['event']->end);
            $data['event']->registration_deadline = Carbon::createFromFormat('Y-m-d H:i:s', $data['event']->registration_deadline);
            $data['event']->tags = json_decode($data['event']->tags);
            return view('event::frontend.details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function eventList()
    {

        try {
            $data['title'] = ___('frontend.Events');
            $data['locations'] = $this->event->model()->active()->visible()->orderBy('address', 'ASC')->groupBy('address')->get('address');
            $data['event_categories'] = $this->eventCategory->model()->active()->orderBy('title', 'ASC')->get();
            return view('event::frontend.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function ajaxEventList(Request $request)
    {
        try {
            $data['events'] = $this->event->model()->active()->visible()->search($request)->orderBy('id', 'ASC')->paginate(9);
            $data['title'] = ___('frontend.Events');
            $data['url'] = route('event.home.event.list');
            $view = view('event::frontend.ajax.filter', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Events');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function ajaxHomeEvent()
    {
        try {
            if (Cache::has('events')) {
                $events = Cache::get('events');
            } else {
            }
            $events = $this->event->model()->active()->visible()->orderBy('id', 'ASC')->limit(3)->get();
            Cache::put('events', $events);
            $data['events'] = $events;

            $data['title'] = ___('frontend.Events');
            $data['url'] = route('event.home.event.list');
            $view = view('event::frontend.ajax.home', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Events');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

}
