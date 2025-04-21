<?php

namespace Modules\Event\Repositories;


use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Event\Entities\EventOrganizer;
use Modules\Event\Interfaces\EventOrganizerInterface;

class EventOrganizerRepository implements EventOrganizerInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(EventOrganizer $eventOrganizer)
    {
        $this->model = $eventOrganizer;
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
            $organizer = new $this->model; // create new object of model for store data in database table
            $organizer->name = $request->name;
            $organizer->email = $request->email;
            $organizer->phone = $request->phone;
            $organizer->event_id = decryptFunction($id);
            $organizer->status_id = $request->status_id;
            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'event/organizer/organizer', [], '', 'image'); // upload file and resize image 35x35

                if ($upload['status']) {
                    $organizer->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $organizer->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('event.Event organizer created successfully.')); // return success response
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
            $organizer = $this->model->find($id);
            if (!$organizer) {
                return $this->responseWithError(___('event.Event organizer not found.'), [], 400);
            }
            $organizer->name = $request->name;
            $organizer->email = $request->email;
            $organizer->phone = $request->phone;
            $organizer->status_id = $request->status_id;
            if ($request->hasFile('image')) {
                $upload = $this->uploadFile($request->image, 'event/organizer/organizer', [], $organizer->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $organizer->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $organizer->update(); // save
            DB::commit();
            return $this->responseWithSuccess(___('event.Event organizer updated successfully.'));
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
            $organizer = $this->model->find(decryptFunction($id));
            if(@$organizer->image_id){
                $this->deleteFile($organizer->image_id, 'delete');
            }
            $organizer->delete();
            return $this->responseWithSuccess(___('forum.Event organizer deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
