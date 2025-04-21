<?php

namespace Modules\Api\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Api\Interfaces\AssignmentInterface;
use Modules\Api\Transformers\AssignmentResource;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Api\Collections\AssignmentCollection;
use Modules\Api\Http\Requests\AssignmentSubmitRequest;

class AssignmentController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $user;
    protected $assignment;
    protected $studentInterface;
    protected $enrollInterface;
    protected $orderInterface;
    protected $assignmentRepository;
    protected $template = 'panel.student';

    public function __construct(User $user, StudentInterface $studentInterface, OrderInterface $orderInterface, EnrollInterface $enrollInterface, AssignmentInterface $assignmentRepository)
    {
        $this->user                        = $user;
        $this->studentInterface            = $studentInterface;
        $this->enrollInterface             = $enrollInterface;
        $this->orderInterface              = $orderInterface;
        $this->assignmentRepository        = $assignmentRepository;
    }


    public function index(){
        try {
            $enroll  = $this->enrollInterface->model()->with(['course:id,title'])->where('user_id', Auth::id())->get();
            if ($enroll) {
                $assignments = [];
                foreach ($enroll as $enrolled_course) {
                    $assignmentCollection = new AssignmentCollection($enrolled_course->course->activeAssignments);
                    $assignmentArray = json_encode($assignmentCollection);
                    if ($assignmentCollection->isNotEmpty()) {
                        $assignments = array_merge($assignments, json_decode($assignmentArray));
                    }
                }
                $data['assignments'] = $assignments;

                return $this->responseWithSuccess(___('common.data found'), $data);
            } else {
                return $this->responseWithSuccess(___('common.no data found'), $data);
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function assignmentDetails(Request $request, $assignment_id)
    {
        try {

            $result = $this->assignmentRepository->assignmentDetails($request, $assignment_id);

            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data'], 200); // return error response
            } else {
                return $this->responseWithError($result->original['message'], $result->original['data'], 400); // return error response
            }

        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function assignmentStore(AssignmentSubmitRequest $request, $assignment_id)
    {
        try {
            $result = $this->assignmentRepository->store($request, $assignment_id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], [], 200); // return error response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}

