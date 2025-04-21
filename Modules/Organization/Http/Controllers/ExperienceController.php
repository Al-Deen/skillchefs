<?php

namespace Modules\Organization\Http\Controllers;

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

    public function __construct(InstructorInterface $instructorRepository) {

        $this->instructorRepository          = $instructorRepository;
    }
    // start addExperience
    public function addExperience(Request $request, $id)
    {

        try {
            $data['url'] = route('organization.instructor.store.experience', $id); // url
            $data['title'] = ___('course.Add Experience'); // title
            @$data['button']   = ___('common.Submit'); // button
            $html = view('organization::panel.organization.modal.experience.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function editExperience($key, $id)
    {
        try {
            $data['experience'] = $this->instructorRepository->model()->where('user_id', decryptFunction($id))->select('experience')->first()->experience;
            if (@$data['experience'] && @$data['experience'][$key]) {
                $data['url'] = route('organization.instructor.update.experience', [$key, $id]); // url
                $data['title'] = ___('course.Edit Experience'); // title
                @$data['button']   = ___('common.Update'); // button
                $data['experience'] = $data['experience'][$key];
                $html = view('organization::panel.organization.modal.experience.edit', compact('data'))->render(); // render view
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
            $result = $this->instructorRepository->addExperience($request, decryptFunction($id));
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
            $result = $this->instructorRepository->updateExperience($request, $key, decryptFunction($id));
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
            $result = $this->instructorRepository->deleteExperience($key, decryptFunction($id));
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']); // return success response
            } else {
                return back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }
    // end addInstitute
}
