<?php

namespace Modules\CMS\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\CMS\Entities\AppHomeSection;
use Modules\CMS\Interfaces\HomeSectionInterface;

class HomSectionRepository implements HomeSectionInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(AppHomeSection $appHomeSection)
    {
        $this->model = $appHomeSection;
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Title'),
            ___('common.Color'),
            ___('common.Order'),
            ___('ui_element.status'),
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
        DB::beginTransaction();
        try {
            $home_section = $this->model->find($request->title);
            if (!$home_section) {
                return $this->responseWithError(___('alert.Home section not found.'), [], 400);
            }
            $home_section->color = @$request->color ?? null;
            $home_section->is_delete = 0;
            $home_section->status_id = $request->status_id;
            $home_section->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Home section store successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $home_section = $this->model->find($id);
            if (!$home_section) {
                return $this->responseWithError(___('alert.Home section not found.'), [], 400);
            }
            $home_section->title = $request->title;
            $home_section->color = @$request->color ?? null;
            $old_order = $this->model->where('order', $request->order)->where('type', $home_section->type)->first();
            if ($old_order->id != $home_section->id) {
                $old_order->order = $home_section->order;
                $old_order->save();
            }
            $home_section->order = $request->order;
            $home_section->status_id = $request->status_id;
            $home_section->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Status updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
