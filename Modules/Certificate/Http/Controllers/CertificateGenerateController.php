<?php

namespace Modules\Certificate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Certificate\Interfaces\CertificateGenerateInterface;

class CertificateGenerateController extends Controller
{
    use ApiReturnFormatTrait;

    protected $certificateRepository;
    protected $enrollRepository;

    public function __construct(
        EnrollInterface $enrollRepository,
        CertificateGenerateInterface $certificateRepository
    ) {
        $this->enrollRepository = $enrollRepository;
        $this->certificateRepository = $certificateRepository;
    }
    // course index
    public function index(Request $request)
    {
        try {
            $data['enrolls'] = $this->enrollRepository->model()->where('is_completed', 1)->with('course:id,title,course_duration,point,course_category_id,slug')
                ->search($request)
                ->latest()
                ->paginate(10);
            $data['title'] = ___('student.Certificates'); // title
            return view('certificate::certificates.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function certificateDownload($id)
    {
        try {
            $result = $this->certificateRepository->adminCertificate($id);
            if ($result->original['result']) {
                $data = $result->original['data'];
                return downloadFile($data->image->original); // download file
            } else {
                return redirect()->back()->with('danger', $result['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function certificateView($id)
    {
        try {
            $result = $this->certificateRepository->adminCertificate($id);
            if ($result->original['result']) {
                $data['certificate'] = $result->original['data'];
                $data['title'] = ___('student.Certificate'); // title
                return view('certificate::certificates.view', compact('data'));
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // course certificates
}
