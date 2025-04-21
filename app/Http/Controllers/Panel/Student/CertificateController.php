<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Certificate\Interfaces\CertificateGenerateInterface;
use Modules\Order\Interfaces\EnrollInterface;

class CertificateController extends Controller
{
    use ApiReturnFormatTrait;

    protected $certificateRepository;
    protected $enrollRepository;
    protected $template = 'panel.student.certificate';

    public function __construct(
        EnrollInterface $enrollRepository,
        CertificateGenerateInterface $certificateRepository
    ) {
        $this->enrollRepository = $enrollRepository;
        $this->certificateRepository = $certificateRepository;
    }
    // course certificates
    public function certificates(Request $request)
    {
        try {
            $data['enrolls'] = $this->enrollRepository->model()->where('user_id', Auth::id())->where('is_completed', 1)->with('course:id,title,course_duration,point,course_category_id,slug')
                ->search($request)
                ->latest()
                ->paginate(10);
            $data['title'] = ___('student.Certificates'); // title
            return view($this->template . '.certificates', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function certificateDownload($id)
    {
        try {
            $result = $this->certificateRepository->certificate($id);
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
            $result = $this->certificateRepository->certificate($id);
            if ($result->original['result']) {
                $data['certificate'] = $result->original['data'];
                $data['title'] = ___('student.Certificate'); // title
                return view($this->template . '.certificate', compact('data'));
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // course certificates
}
