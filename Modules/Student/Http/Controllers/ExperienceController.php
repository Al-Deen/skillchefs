<?php

namespace Modules\Student\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;
use Modules\Instructor\Http\Requests\ExperienceRequest;
use Modules\Student\Interfaces\StudentInterface;

class ExperienceController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $student;

    public function __construct(StudentInterface $StudentInterface)
    {
        $this->student = $StudentInterface;
    }
    // start addExperience
    public function addExperience(Request $request, $id)
    {

        try {
            $data['url'] = route('admin.student.store.experience', $id); // url
            $data['title'] = ___('course.Add Experience'); // title
            @$data['button'] = ___('common.Submit'); // button
            $html = view('student::modal.experience.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editExperience($key, $id)
    {

        try {
            $data['experience'] = $this->student->model()->where('user_id', $id)->select('experience')->first()->experience;
            if (@$data['experience'] && @$data['experience'][$key]) {
                $data['url'] = route('admin.student.update.experience', [$key, $id]); // url
                $data['title'] = ___('course.Edit Experience'); // title
                @$data['button'] = ___('common.Update'); // button
                $data['experience'] = $data['experience'][$key];
                $html = view('student::modal.experience.edit', compact('data'))->render(); // render view
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
            } else {
                return $this->responseWithError(___('alert.Education Not Found'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeExperience(ExperienceRequest $request, $id)
    {
        try {
            $result = $this->student->addExperience($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function updateExperience(ExperienceRequest $request, $key, $id)
    {

        try {
            $result = $this->student->updateExperience($request, $key, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteExperience($key, $id)
    {

        try {
            $result = $this->student->deleteExperience($key, $id);
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
