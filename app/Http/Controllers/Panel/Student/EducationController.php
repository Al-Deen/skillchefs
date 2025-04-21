<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;
use Modules\Student\Http\Requests\InstituteRequest;
use Modules\Student\Interfaces\StudentInterface;

class EducationController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $studentRepository;
    protected $template = 'panel.student';

    public function __construct(
        StudentInterface $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
    }
    // start addInstitute
    public function addInstitute(Request $request)
    {

        try {
            $data['url'] = route('student.store.institute'); // url
            $data['title'] = ___('course.Add Education'); // title
            @$data['button'] = ___('common.Submit'); // button
            $html = view('panel.student.partials.modal.institute.create_institute', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editInstitute($key)
    {

        try {
            $data['institute'] = $this->studentRepository->model()->where('user_id', auth()->user()->id)->select('education')->first()->education;
            if (@$data['institute'] && @$data['institute'][$key]) {
                $data['url'] = route('student.update.institute', $key); // url
                $data['title'] = ___('course.Edit Education'); // title
                @$data['button'] = ___('common.Update'); // button
                $data['institute'] = $data['institute'][$key];
                $html = view('panel.student.partials.modal.institute.edit_institute', compact('data'))->render(); // render view
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
            } else {
                return $this->responseWithError(___('alert.Education Not Found'), [], 400); // return error response
            }
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeInstitute(InstituteRequest $request)
    {

        try {
            $result = $this->studentRepository->addInstitute($request, auth()->user()->id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function updateInstitute(InstituteRequest $request, $key)
    {

        try {
            $result = $this->studentRepository->updateInstitute($request, $key, auth()->user()->id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteInstitute($key)
    {

        try {
            $result = $this->studentRepository->deleteInstitute($key, auth()->user()->id);
            if ($result->original['result']) {
                return redirect()->route('student.setting', ['educations'])->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->route('student.setting', ['educations'])->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->route('student.setting', ['educations'])->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    // end addInstitute
}
