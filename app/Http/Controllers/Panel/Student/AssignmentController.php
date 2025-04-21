<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Http\Requests\AssignmentSubmitRequest;
use Modules\Course\Interfaces\AssignmentSubmitInterface;
use Modules\Order\Interfaces\EnrollInterface;

class AssignmentController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $enrollRepository;
    protected $assignmentSubmitRepository;
    protected $template = 'panel.student';

    public function __construct(EnrollInterface $enrollRepository, AssignmentSubmitInterface $assignmentSubmitRepository)
    {
        $this->enrollRepository = $enrollRepository;
        $this->assignmentSubmitRepository = $assignmentSubmitRepository;
    }
    public function assignmentDetails($enroll_id, $assignment_id)
    {
        try {
            $enroll_id = decryptFunction($enroll_id);
            $assignment_id = decryptFunction($assignment_id);
            $enroll = $this->enrollRepository->model()->where('user_id', Auth::id())->where('id', $enroll_id)->first();
            $assignment = @$enroll->course->assignments->where('id', $assignment_id)->first();
            if ($enroll && @$assignment) {
                $data['assignment'] = $assignment;
                $data['url'] = route('student.assignment.store', [encryptFunction($enroll_id), encryptFunction($assignment_id)]); // url
                $data['title'] = ___('course.Assignment Details'); // title
                @$data['button'] = ___('common.Submit');
                $data['enroll_id'] = encryptFunction($enroll_id);
                $html = view('panel.student.course.modal.assignment.create', compact('data'))->render(); // render view
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
            } else {
                return $this->responseWithError(___('alert.Enroll not found'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function assignmentDownload($enroll, $assignment_id)
    {
        try {
            $enroll_id = decryptFunction($enroll);
            $assignment_id = decryptFunction($assignment_id);
            $enroll = $this->enrollRepository->model()->where('user_id', Auth::id())->where('id', $enroll_id)->first();
            $assignment = @$enroll->course->assignments->where('id', $assignment_id)->first();
            if ($enroll && @$assignment) {
                $file = @$assignment->assignmentFile->original;
                if ($file) {
                    return downloadFile($file); // download file
                } else {
                    return redirect()->back()->with('danger', ___('alert.File not found')); // return error response
                }
            } else {
                return redirect()->back()->with('danger', ___('alert.Enroll not found')); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    public function assignmentStore(AssignmentSubmitRequest $request, $enroll_id, $assignment_id)
    {

        try {
            $result = $this->assignmentSubmitRepository->store($request, $enroll_id, $assignment_id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], [], 200); // return error response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
