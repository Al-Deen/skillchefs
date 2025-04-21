<?php

namespace App\Http\Controllers\Panel\Instructor;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Instructor\Http\Requests\ExperienceRequest;

class ExperienceController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $instructorRepository;
    protected $template = 'panel.instructor';

    public function __construct(InstructorInterface $instructorRepository) {

        $this->instructorRepository          = $instructorRepository;
    }
    // start addExperience
    public function addExperience(Request $request)
    {

        try {
            $data['url'] = route('instructor.store.experience'); // url
            $data['title'] = ___('course.Add Experience'); // title
            @$data['button']   = ___('common.Submit'); // button
            $html = view('panel.instructor.modal.experience.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editExperience($key)
    {

        try {
            $data['experience'] = $this->instructorRepository->model()->where('user_id', auth()->user()->id)->select('experience')->first()->experience;
            if (@$data['experience'] && @$data['experience'][$key]) {
                $data['url'] = route('instructor.update.experience', $key); // url
                $data['title'] = ___('course.Edit Experience'); // title
                @$data['button']   = ___('common.Update'); // button
                $data['experience'] = $data['experience'][$key];
                $html = view('panel.instructor.modal.experience.edit', compact('data'))->render(); // render view
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
            $result = $this->instructorRepository->addExperience($request, auth()->user()->id);
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
            $result = $this->instructorRepository->updateExperience($request, $key, auth()->user()->id);
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
            $result = $this->instructorRepository->deleteExperience($key, auth()->user()->id);
            if ($result->original['result']) {
                return redirect()->route('instructor.setting', ['experiences'])->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->route('instructor.setting', ['experiences'])->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->route('instructor.setting', ['experiences'])->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    // end addInstitute
}
