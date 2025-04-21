<?php

namespace Modules\Slider\Repositories;

use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Slider\Entities\Slider;
use App\Traits\ApiReturnFormatTrait;
use Modules\Slider\Interfaces\SliderInterface;
use Modules\Course\Transformers\SliderCollection;

class SliderRepository implements SliderInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(Slider $sliderModel)
    {
        $this->model = $sliderModel;
    }

    public function getAll($request)
    {

        try {
            $data = $this->model->query()->with('iconImage');

            $data = $this->filter($request, $data);

            $data = $data->orderBy('serial', 'asc')->paginate($request->show ?? 10);

            return $data;
        } catch (\Throwable $th) {

            return false;
        }
    }

    public function all()
    {

        return $this->model->get();
    }

    public function filter($request, $data)
    {

        if (!empty($request->search)) {
            $search = $request->search;
            $data = $data->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('sub_title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $data;
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Title'),
            ___('common.Sub Title'),
            ___('common.Image'),
            ___('ui_element.status'),
            ___('common.serial'),
            ___('ui_element.created_at'),
            ___('ui_element.action'),
        ];
    }

    public function model()
    {
        try {
            return $this->model;
        } catch (\Throwable $th) {

            return false;
        }
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction

        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = new $this->model; // create new object of model for store data in database table
            $target->title = $request->title;
            $target->sub_title = $request->sub_title;
            $target->button_url = $request->button_url;
            $target->button_text = $request->button_text;
            $target->status_id = $request->status_id;
            $target->serial = $request->serial;
            $target->created_by = auth()->id();
            $target->description = $request->description ?? '';
            // icon upload
            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'Slider/image/images', [[1260, 400]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            $target->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Slider created successfully.')); // return success response
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
            $target = $this->model->find($id);
            if (!$target) {
                return $this->responseWithError(___('alert.Slider not found.'), [], 400);
            }

            $target->title = $request->title;
            $target->sub_title = $request->sub_title;
            $target->button_url = $request->button_url;
            $target->button_text = $request->button_text;
            $target->status_id = $request->status_id;
            $target->serial = $request->serial;
            $target->created_by = auth()->id();
            $target->description = $request->description ?? '';

            // Image upload
            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'Slider/image/images', [[1260, 400]], @$target->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            $target->save();
            // cache()->forget('sliders');
            DB::commit();
            return $this->responseWithSuccess(___('alert.Slider updated successfully.'));
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

            $target = $this->model->find($id);

            $upload = $this->deleteFile($target->image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }

            $target->delete();

            return $this->responseWithSuccess(___('alert.Slider deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // Use this functon on front end + api
    public function getAllSLider()
    {
        try {
            $sliders =  $this->model->query()->active()->with('iconImage:id,original')->orderBy('serial', 'asc')->get();

            return new SliderCollection($sliders);

        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function sliderDetails($request)
    {
        try {
            return $this->model->query()->active()->with('iconImage:id,original')->where('id', $request->id)->first();
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // Use this functon on front end
}
