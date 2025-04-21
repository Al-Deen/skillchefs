<?php

namespace Modules\Api\Repositories;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Enroll;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Course\Entities\Assignment;
use Modules\Course\Entities\AssignmentSubmit;
use Modules\Api\Interfaces\AssignmentInterface;
use Modules\Api\Transformers\AssignmentResource;


class AssignmentRepository implements AssignmentInterface
{

    use ApiReturnFormatTrait, FileUploadTrait;

    protected $model;
    protected $studentModel;

    public function __construct(AssignmentSubmit $assignmentSubmit, Assignment $assignmentModel)
    {
        $this->model = $assignmentSubmit;
        $this->assignmentModel = $assignmentModel;
    }

    public function model(){
        return $this->model;
    }

    public function assignmentModel(){
        return $this->assignmentModel;
    }

    public function store($request, $assignment_id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $assignmentModel = $this->assignmentModel->where('id', $assignment_id)->first(); // get assignment model
            if (!$assignmentModel) {
                return $this->responseWithError(___('alert.Assignment not found'), [], 400); // return error response
            }
            $assignmentSubmitModel = $this->model->where('user_id', Auth::id())->where('assignment_id', $assignment_id)->first(); // get assignment submit model
            if ($assignmentSubmitModel) {
                return $this->responseWithError(___('alert.Assignment already submitted'), [], 400); // return error response
            }
            $course_enroll = Enroll::where('user_id', auth()->id())->where('course_id', $assignmentModel->course()->first()->id)->first();
            $assignmentSubmitModel = $this->model; // get assignment submit model
            $assignmentSubmitModel->user_id = Auth::id(); // user_id
            $assignmentSubmitModel->assignment_id = $assignment_id; // assignment_id
            $assignmentSubmitModel->enroll_id = $course_enroll->id; // enroll_id
            $assignmentSubmitModel->is_submitted = 11; // is_submitted
            // assignment_file upload
            if ($request->hasFile('assignment_file')) {
                $upload = $this->uploadFile($request->assignment_file, 'course/assignment/submission/assignment_file', [], '', 'file'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $assignmentSubmitModel->assignment_file = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $assignmentSubmitModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course assignment submitted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function assignmentDetails($request, $assignment_id)
    {

        $assignment = @$this->assignmentModel()->where('id', $assignment_id)->first();

            if ($assignment) {
                $data['assignment'] = new AssignmentResource($assignment);

                return $this->responseWithSuccess(___('common.data found'), $data);
            } else {
                $data['assignments'] = [];

                return $this->responseWithSuccess(___('common.no data found'), $data);
            }
    }
}
