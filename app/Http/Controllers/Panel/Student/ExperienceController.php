<?php

namespace App\Http\Controllers\Panel\Student;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Student\Http\Requests\ExperienceRequest;

class ExperienceController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $studentRepository;
    protected $template = 'panel.student';

    public function __construct(StudentInterface $studentRepository) {

        $this->studentRepository          = $studentRepository;
    }
    // start addExperience
    public function addExperience(Request $request)
    {

        try {
            $data['url'] = route('student.store.experience'); // url
            $data['title'] = ___('course.Add Experience'); // title
            @$data['button']   = ___('common.Submit'); // button
            $html = view('panel.student.partials.modal.experience.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editExperience($key)
    {

        try {
            $data['experience'] = $this->studentRepository->model()->where('user_id', auth()->user()->id)->select('experience')->first()->experience;
            if (@$data['experience'] && @$data['experience'][$key]) {
                $data['url'] = route('student.update.experience', $key); // url
                $data['title'] = ___('course.Edit Experience'); // title
                @$data['button']   = ___('common.Update'); // button
                $data['experience'] = $data['experience'][$key];
                $html = view('panel.student.partials.modal.experience.edit', compact('data'))->render(); // render view
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
            } else {
                return $this->responseWithError(___('alert.Education Not Found'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeExperience(ExperienceRequest $request)
    {
        try {
            $result = $this->studentRepository->addExperience($request, auth()->user()->id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function updateExperience(ExperienceRequest $request, $key)
    {

        try {
            $result = $this->studentRepository->updateExperience($request, $key, auth()->user()->id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteExperience($key)
    {

        try {
            $result = $this->studentRepository->deleteExperience($key, auth()->user()->id);
            if ($result->original['result']) {
                return redirect()->route('student.setting', ['experiences'])->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->route('student.setting', ['experiences'])->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->route('student.setting', ['experiences'])->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    // end addInstitute
}
