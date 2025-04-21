<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Student\Interfaces\StudentInterface;
use Modules\instructor\Http\Requests\InstituteRequest;

class EducationController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    // constructor injection
    protected $student;

    public function __construct(StudentInterface $StudentInterface)
    {
        $this->student = $StudentInterface;
    }
    // start addInstitute
    public function addInstitute(Request $request, $id)
    {

        try {
            $data['url'] = route('admin.student.store.institute', $id); // url
            $data['title'] = ___('course.Add Education'); // title
            @$data['button'] = ___('common.Submit'); // button
            $html = view('student::modal.institute.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editInstitute($key, $id)
    {

        try {
            $data['institute'] = $this->student->model()->where('user_id', $id)->select('education')->first()->education;
            if (@$data['institute'] && @$data['institute'][$key]) {
                $data['url'] = route('admin.student.update.institute', [$key, $id]); // url
                $data['title'] = ___('course.Edit Education'); // title
                @$data['button'] = ___('common.Update'); // button
                $data['institute'] = $data['institute'][$key];
                $html = view('student::modal.institute.edit', compact('data'))->render(); // render view
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
            } else {
                return $this->responseWithError(___('alert.Education Not Found'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeInstitute(InstituteRequest $request, $id)
    {

        try {
            $result = $this->student->addInstitute($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function updateInstitute(InstituteRequest $request, $key, $id)
    {

        try {
            $result = $this->student->updateInstitute($request, $key, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteInstitute($key, $id)
    {

        try {
            $result = $this->student->deleteInstitute($key, $id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    // end addInstitute
}
