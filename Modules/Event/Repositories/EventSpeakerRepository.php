<?php

namespace Modules\Event\Repositories;


use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Event\Entities\EventSchedule;
use Modules\Event\Entities\EventScheduleList;
use Modules\Event\Entities\EventSpeaker;
use Modules\Event\Interfaces\EventSpeakerInterface;

class EventSpeakerRepository implements EventSpeakerInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(EventSpeaker $eventSpeaker)
    {
        $this->model = $eventSpeaker;
    }

    public function all()
    {
        try {
            return $this->model->get();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function model()
    {
        try {
            return $this->model;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function store($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $speaker = new $this->model; // create new object of model for store data in database table
            $speaker->name = $request->name;
            $speaker->designation = $request->designation;
            $speaker->event_id = decryptFunction($id);
            $speaker->status_id = $request->status_id;
            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'event/speaker/speaker', [], '', 'image'); // upload file and resize image 35x35

                if ($upload['status']) {
                    $speaker->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $speaker->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('event.Event speaker created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $speaker = $this->model->find($id);
            if (!$speaker) {
                return $this->responseWithError(___('event.Event speaker not found.'), [], 400);
            }
            $speaker->name = $request->name;
            $speaker->designation = $request->designation;
            $speaker->status_id = $request->status_id;
            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'event/speaker/speaker', [], $speaker->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $speaker->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $speaker->update(); // save
            DB::commit();
            return $this->responseWithSuccess(___('event.Event speaker updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $speaker = $this->model->find(decryptFunction($id));
            if(@$speaker->image_id){
                $this->deleteFile($speaker->image_id, 'delete');
            }
            $speaker->delete();
            return $this->responseWithSuccess(___('forum.Event speaker deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
