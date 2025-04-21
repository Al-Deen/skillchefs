<?php

namespace Modules\Course\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Assignment;
use Modules\Course\Entities\AssignmentSubmit;
use Modules\Course\Entities\Course;
use Modules\Course\Interfaces\AssignmentSubmitInterface;
use Termwind\Components\Dd;

class AssignmentSubmitRepository implements AssignmentSubmitInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $assignmentModel;

    public function __construct(AssignmentSubmit $assignmentSubmit, Assignment $assignmentModel)
    {
        $this->model = $assignmentSubmit;
        $this->assignmentModel = $assignmentModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($request, $enroll_id, $assignment_id)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $enroll_id = decryptFunction($enroll_id);
            $assignment_id = decryptFunction($assignment_id);
            $assignmentModel = $this->assignmentModel->where('id', $assignment_id)->first(); // get assignment model
            if (!$assignmentModel) {
                return $this->responseWithError(___('alert.Assignment not found'), [], 400); // return error response
            }
            $assignmentSubmitModel = $this->model->where('user_id', Auth::id())->where('assignment_id', $assignment_id)->first(); // get assignment submit model
            if ($assignmentSubmitModel) {
                return $this->responseWithError(___('alert.Assignment already submitted'), [], 400); // return error response
            }
            $assignmentSubmitModel = $this->model; // get assignment submit model
            $assignmentSubmitModel->user_id = Auth::id(); // user_id
            $assignmentSubmitModel->assignment_id = $assignment_id; // assignment_id
            $assignmentSubmitModel->enroll_id = $enroll_id; // enroll_id
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
    
    public function review($request, $assignment_id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $assignment_id = decryptFunction($assignment_id);
            $assignmentSubmitModel = $this->model->where('id', $assignment_id)->first(); // get assignment model
            if (!$assignmentSubmitModel) {
                return $this->responseWithError(___('alert.Assignment submission not found'), [], 400); // return error response
            }
            $assignmentSubmitModel->marks = $request->marks; // marks
            if (@$assignmentSubmitModel->assignment->pass_marks <= $request->marks) {
                $assignmentSubmitModel->status_id = 25; // 25 = passed
            } else {
                $assignmentSubmitModel->status_id = 24; // 24 = failed
            }
            $assignmentSubmitModel->is_reviewed = 1; // is_reviewed
            $assignmentSubmitModel->details = $request->review; // review
            $assignmentSubmitModel->save(); // save data in database table

            $enroll = $assignmentSubmitModel->enroll;
            $completed_assignments = $enroll->completed_assignments ?? [];
            $completed_assignments = array_unique(array_merge($completed_assignments, [$assignmentSubmitModel->assignment_id]));

            if (@$assignmentSubmitModel->assignment->pass_marks <= $request->marks) {

                $progress = number_format(((count(@$enroll->completed_quizzes ?? []) + count($enroll->completed_lessons ?? []) + count(@$completed_assignments ?? [])) / ($enroll->lessons->count() + $enroll->course->activeAssignments->count())) * 100, 2);
                $enroll->update([
                    'completed_assignments' => $completed_assignments,
                    'progress' => $progress,
                    'assignment_point' => $enroll->assignment_point + $assignmentSubmitModel->assignment->point,
                ]);
                if ($progress == 100 && $enroll->is_completed == 0) {
                    $enroll->completed($enroll);
                }
            } else {
                $enroll = $assignmentSubmitModel->enroll;
                $enroll->update([
                    'completed_assignments' => $completed_assignments,
                ]);
            }

            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Assignment submission reviewed successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
