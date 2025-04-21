<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Api\Collections\CertificateCollection;
use Modules\Certificate\Entities\CertificateGenerate;
use Modules\Certificate\Interfaces\CertificateGenerateInterface;

class CertificateController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $model;
    protected $certificateRepository;
    protected $enrollRepository;

    public function __construct(
        CertificateGenerate $certificateGenerateModel,
        EnrollInterface $enrollRepository,
        CertificateGenerateInterface $certificateRepository,
    ) {
        $this->model = $certificateGenerateModel;
        $this->enrollRepository = $enrollRepository;
        $this->certificateRepository = $certificateRepository;
    }


    public function index(Request $request)
    {
        try {
            $certificate = $this->model->where('user_id', auth()->id())->get();
            if($certificate->isNotEmpty()){
                $data['certificates'] = new CertificateCollection($certificate);

                return $this->responseWithSuccess(___('student.data found'), $data);
            }else{
                return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function certificateDownload($id)
    {
        try {
            $certificate = $this->model->where('user_id', auth()->id())->where('id', $id)->first();
            if ($certificate->isNotEmpty()) {
                return downloadFile($certificate->image->original); // download file
            } else {
                return redirect()->back()->with('danger', $result['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
