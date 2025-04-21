<?php

namespace Modules\Event\Repositories;


use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Event\Entities\EventSchedule;
use Modules\Event\Entities\EventScheduleList;
use Modules\Event\Interfaces\EventScheduleInterface;

class EventScheduleRepository implements EventScheduleInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $scheduleList;

    public function __construct(EventSchedule $eventSchedule, EventScheduleList $eventScheduleList)
    {
        $this->model = $eventSchedule;
        $this->scheduleList = $eventScheduleList;
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

    public function scheduleListModel()
    {
        try {
            return $this->scheduleList;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function getActive()
    {
        try {
            if (Cache::has('forum_category')) {
                $questionCategories = Cache::get('forum_category');
            } else {
                $questionCategories = $this->model->where('status_id', 1)->get(); // get all home section
                Cache::put('forum_category', $questionCategories);
            }
            return $questionCategories;

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
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }
        DB::beginTransaction(); // start database transaction
        try {
            $target = new $this->model; // create new object of model for store data in database table
            $target->title = $request->title;
            $target->date = $request->date;
            $target->status_id = $request->status_id;
            $target->event_id = decryptFunction($id);
            $target->created_by = auth()->id();
            $target->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('event.Schedule date created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        try {
            return $this->model->find($id);
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = $this->model->find(decryptFunction($id));
            if (!$target) {
                return $this->responseWithError(___('event.Event Schedule not found.'), [], 400);
            }
            $target->title = $request->title;
            $target->date = $request->date;
            $target->status_id = $request->status_id;
            $target->update(); // save
            DB::commit();
            return $this->responseWithSuccess(___('event.Event Date Schedule updated successfully.'));
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

            $target = $this->model->find(decryptFunction($id));
            $target->delete();
            return $this->responseWithSuccess(___('forum.Event Date Schedule deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // Event List
    public function listStore($request, $id)
    {
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }

        DB::beginTransaction(); // start database transaction
        try {
            $target = new $this->scheduleList; // create new object of model for store data in database table
            $target->title = $request->title;
            $target->from_time = $request->from_time;
            $target->to_time = $request->to_time;
            $target->location = $request->location;
            $target->details = $request->details;
            $target->status_id = $request->status_id;
            $target->event_schedule_id = decryptFunction($id);
            $target->created_by = auth()->id();
            $target->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('event.Schedule timeline created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function listUpdate($request, $id)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = $this->scheduleList->find(decryptFunction($id));
            if (!$target) {
                return $this->responseWithError(___('event.Event Timeline not found.'), [], 400);
            }
            $target->title = $request->title;
            $target->from_time = $request->from_time;
            $target->to_time = $request->to_time;
            $target->location = $request->location;
            $target->details = $request->details;
            $target->status_id = $request->status_id;
            $target->update(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('event.Event timeline updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function listDestroy($id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = $this->scheduleList->find(decryptFunction($id));
            $target->delete();
            return $this->responseWithSuccess(___('forum.Forum category deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
