<?php

namespace Modules\Brand\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Interfaces\BrandInterface;

class BrandRepository implements BrandInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(Brand $BrandModel)
    {
        $this->model = $BrandModel;
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
        try {
            return $this->model->query()->with('iconImage:id,original')->where('status_id', 1)->orderBy('serial', 'asc')->get();

        } catch (\Throwable $th) {

            return false;
        }

    }

    public function filter($request, $data)
    {

        if (!empty($request->search)) {
            $search = $request->search;
            $data = $data->where(function ($query) use ($search) {
                $query->where('serial', 'like', "%{$search}%");
            });
        }

        return $data;
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
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
            $target->status_id = $request->status_id;
            $target->serial = $request->serial;
            $target->created_by = auth()->id();
            // icon upload
            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'brand/image/images', [[200, 50]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            $target->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Brand created successfully.')); // return success response
        } catch (\Throwable $th) {

            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        try {
            return $this->model->with('iconImage')->find($id);

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
                return $this->responseWithError(___('alert.Brand not found.'), [], 400);
            }

            $target->status_id = $request->status_id;
            $target->serial = $request->serial;
            $target->created_by = auth()->id();

            // Image upload
            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'brand/image/images', [[200, 50]], @$target->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            $target->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Brand updated successfully.'));
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

            return $this->responseWithSuccess(___('alert.Brand deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // Using this function at front end
    public function getAllBrands()
    {

        try {

            return $this->model->query()->active()->with('iconImage:id,original')->select('id', 'image_id')->orderBy('serial', 'asc')->get();
        } catch (\Throwable $th) {
            return false;
        }
    }
    // Using this function at front end
}
