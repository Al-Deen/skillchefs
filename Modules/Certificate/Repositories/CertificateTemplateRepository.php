<?php

namespace Modules\Certificate\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Certificate\Interfaces\CertificateTemplateInterface;

class CertificateTemplateRepository implements CertificateTemplateInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;

    public function __construct(CertificateTemplate $certificateModel)
    {
        $this->model = $certificateModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {

            $template = new $this->model;
            $template->title = $request->title;
            $template->status_id = $request->status_id;
            if ($request->has('default_id')) {
                $this->model->where('default_id', 11)->update(['default_id' => 10]);
                $template->default_id = $request->default_id;
            }
            $template->text = $request->text;
            $template->save();
            if ($request->hasFile('template')) {
                if(imagecreatefrompng($request->template) == false) {
                    return $this->responseWithError(___('alert.please_upload_valid_png_image'), [], 400);
                }
                $upload = $this->uploadFile($request->template, 'templates/template', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $template->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $template->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Template created successfully.'), $template); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $template = $this->model()->find($id);
            if (!$template) {
                return $this->responseWithError(___('alert.template_not_found'), [], 400); // return error response
            }
            if ($this->model->where('default_id', 11)->count() == 1 && $request->default_id == 10) {
                return $this->responseWithError(___('alert.you_have_to_select_at_list_one_default'), [], 400); // return error response
            }
            $template->title = $request->title;
            $template->status_id = $request->status_id;
            if ($request->has('default_id') && $request->default_id != $template->default_id) {
                $this->model->where('id', '!=', $template->id)->where('default_id', 11)->update(['default_id' => 10]);
                $template->default_id = $request->default_id;
            }
            $template->text = $request->text;
            $template->save();
            if ($request->hasFile('template')) {
                if(imagecreatefrompng($request->template) == false) {
                    return $this->responseWithError(___('alert.please_upload_valid_png_image'), [], 400);
                }
                $upload = $this->uploadFile($request->template, 'templates/template', [], $template->image_id, 'file'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $template->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $template->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Template updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $template = $this->model()->find($id);
            if (!$template) {
                return $this->responseWithError(___('alert.Template not found'), [], 400); // return error response
            }
            $upload = $this->deleteFile($template->image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $template->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Template deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
