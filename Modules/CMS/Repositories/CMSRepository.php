<?php

namespace Modules\CMS\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\CMS\Entities\AppHomeSection;
use Modules\CMS\Interfaces\CMSInterface;

class CMSRepository implements CMSInterface
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
            ___('common.Order'),
            ___('ui_element.status'),
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

    public function update($request)
    {
        DB::beginTransaction();
        try {
            $target = $this->model->find($request->id);

            if (!$target) {
                return $this->responseWithError(___('alert.Data not found.'), [], 400);
            }

            if ($target->status_id == 1) {
                $changeStatus = 2;
            } else if ($target->status_id == 2) {
                $changeStatus = 1;
            }

            $target->status_id = $changeStatus;
            $target->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Status updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
