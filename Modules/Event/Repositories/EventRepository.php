<?php

namespace Modules\Event\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Event\Entities\Event;
use Modules\Event\Interfaces\EventInterface;

class EventRepository implements EventInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(Event $eventModel)
    {
        $this->model = $eventModel;
    }

    public function model()
    {
        try {
            return $this->model;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function tableHeader()
    {
        return [
            ___('event.ID'),
            ___('event.Event Title'),
            ___('event.Event Type'),
            ___('event.Category'),
            ___('event.Ticket Price'),
            ___('event.Event Duration'),
            ___('event.Created By'),
            ___('event.Visibility'),
            ___('event.Status'),
            ___('event.Action'),
        ];
    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function dateTime($type, $data)
    {
        try {
            $dateTimeParts = explode(" - ", $data);
            $startDateTime = trim($dateTimeParts[0]);
            $startTimestamp = Carbon::createFromFormat('d/m/Y h:i A', $startDateTime);

            if (isset($dateTimeParts[1])) {
                $endDateTime = trim($dateTimeParts[1]);
                $endTimestamp = Carbon::createFromFormat('d/m/Y h:i A', $endDateTime);
            }

            switch ($type) {
                case 'time':
                    $response = $startTimestamp->format('H:i:s');
                    break;
                case 'date':
                    $response = $startTimestamp->format('Y-m-d');
                    break;
                case 'date_time':
                    $response = $startTimestamp->format('Y-m-d H:i:s');
                    break;
                case 'start':
                    $response = $startTimestamp->format('Y-m-d H:i:s');
                    break;
                case 'end':
                    $response = $endTimestamp->format('Y-m-d H:i:s');
                    break;
                default:
                    $response = "Wrong Type";
                    break;
            }

            return $response;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function store($request)
    {
        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $event = new $this->model();
            $event->title = $request->title;
            $event->description = $request->description;
            // thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $upload = $this->uploadFile($request->thumbnail, 'event/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $event->thumbnail = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $event->slug = Str::slug($request->title) . '-' . mt_rand(100000, 999999);
            $event->address = $request->address;
            $event->event_type = $request->event_type;
            $event->online_welcome_media = $request->online_welcome_media;
            $event->online_media = $request->online_media;
            $event->online_link = $request->online_link;
            $event->online_note = $request->online_note;
            $event->end = date("Y-m-d H:i:s", strtotime($request->event_duration));
            $event->start = date("Y-m-d H:i:s", strtotime($request->event_duration));
            $event->registration_deadline = date("Y-m-d H:i:s", strtotime($request->registration_deadline));
            $event->tags = $request->tags;
            $event->max_participant = $request->max_participant;
            $event->show_participant = $request->show_participant;
            $event->is_paid = $request->is_paid;
            $event->price = $request->price;
            $event->category_id = $request->category;
            $event->visibility_id = $request->visibility_id;
            $event->status_id = 3;
            $event->created_by = Auth::id();
            $event->save();

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('event.Event created successfully.'), $event->id); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $event = $this->model()->findOrFail(decryptFunction($id));
            $event->title = $request->title;
            $event->description = $request->description;
            // thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $upload = $this->uploadFile($request->thumbnail, 'event/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $event->thumbnail = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $event->address = $request->address;
            $event->event_type = $request->event_type;
            $event->online_welcome_media = $request->online_welcome_media;
            $event->online_media = $request->online_media;
            $event->online_link = $request->online_link;
            $event->online_note = $request->online_note;
            $event->start = $this->dateTime('start', $request->event_duration);
            $event->end = $this->dateTime('end', $request->event_duration);
            $event->registration_deadline = date("Y-m-d H:i:s", strtotime($request->registration_deadline));
            $event->tags = $request->tags;
            $event->max_participant = $request->max_participant;
            $event->show_participant = $request->show_participant;
            $event->is_paid = $request->is_paid;
            $event->price = $request->price;
            $event->category_id = $request->category;
            $event->visibility_id = $request->visibility_id;
            $event->status_id = 3;
            $event->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('event.Event updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = $this->model->find(decryptFunction($id));
            $target->delete();

            return $this->responseWithSuccess(___('event.Event deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // admin panel request approval
    public function approve($event_id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $event = $this->model()->where('id', $event_id)->first();
            $event->status_id = 4;
            $event->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Event approved successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    // admin panel request reject
    public function reject($event_id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $event = $this->model()->where('id', $event_id)->first();
            $event->status_id = 6;
            $event->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Event rejected successfully'), [], 200);
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
