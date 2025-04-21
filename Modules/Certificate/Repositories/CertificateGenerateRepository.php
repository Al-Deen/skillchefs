<?php

namespace Modules\Certificate\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\CertificateTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Certificate\Entities\CertificateGenerate;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Certificate\Interfaces\CertificateGenerateInterface;
use Modules\Order\Entities\Enroll;

class CertificateGenerateRepository implements CertificateGenerateInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait, CertificateTrait;

    private $model;
    private $certificateTemplateModel;
    private $enrollModel;

    public function __construct(CertificateGenerate $certificateGenerateModel, CertificateTemplate $certificateTemplateModel, Enroll $enrollModel)
    {
        $this->model = $certificateGenerateModel;
        $this->certificateTemplateModel = $certificateTemplateModel;
        $this->enrollModel = $enrollModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function certificate($id)
    {
        try {
            $enroll = $this->enrollModel->where('user_id', Auth::id())->where('id', decryptFunction($id))->where('is_completed', 1)->first();
            if (!$enroll) {
                return $this->responseWithError(___("alert.Sorry You didn't complete this course"), [], 400); // return error response
            }
            $certificate = $this->model->where('user_id', Auth::id())->where('enroll_id', decryptFunction($id))->first();
            if (!$certificate) {
                $result = $this->store($enroll);
                if ($result->original['result']) {
                    $certificate = $result->original['data'];
                } else {
                    return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                }
            }
            return $this->responseWithSuccess(___('alert.Certificate retrieve successfully.'), $certificate); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }

    }
    public function adminCertificate($id)
    {
        try {
            $enroll = $this->enrollModel->where('id', decryptFunction($id))->where('is_completed', 1)->first();
            if (!$enroll) {
                return $this->responseWithError(___("alert.Sorry You didn't complete this course"), [], 400); // return error response
            }
            $certificate = $this->model->where('enroll_id', decryptFunction($id))->first();
            if (!$certificate) {
                $result = $this->store($enroll);
                if ($result->original['result']) {
                    $certificate = $result->original['data'];
                } else {
                    return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                }
            }
            return $this->responseWithSuccess(___('alert.Certificate retrieve successfully.'), $certificate); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }

    }
    public function store($enroll)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $template = $this->certificateTemplateModel->where('default_id',11)->first();
            $certificate = new $this->model;
            $certificate->enroll_id = $enroll->id;
            $certificate->user_id = Auth::id();
            $certificate->certificate_id = rand(100000, 999999) . time();
            $certificateImage = $this->generateCertificate($template, $enroll, $certificate->certificate_id);
            if ($certificateImage['status']) {
                $upload = $this->uploadFile($certificateImage['certificate'], 'enroll/certificates/certificate', [], '', 'image'); // upload file and resize image 35x35
                if(file_exists($certificateImage['certificate'])){
                    unlink($certificateImage['certificate']);
                }
                if ($upload['status']) {
                    $certificate->upload_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            } else {
                if(file_exists($certificateImage['certificate'])){
                    unlink($certificateImage['certificate']);
                }
                return $this->responseWithError($certificateImage['message'], [], 400);
            }
            $certificate->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Certificate generate successfully.'), $certificate); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            dd($th);
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $note = $this->model()->where('user_id', Auth::id())->find($id);
            if (!$note) {
                return $this->responseWithError(___('alert.Note not found'), [], 400); // return error response
            }
            $note->description = $request->note;
            $note->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $enroll = $this->model()->find($id);
            if (!$enroll) {
                return $this->responseWithError(___('alert.Note not found'), [], 400); // return error response
            }
            $enroll->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
