<?php

namespace Modules\Organization\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;
use Modules\Instructor\Http\Requests\InstituteRequest;
use Modules\Instructor\Interfaces\InstructorInterface;

class EducationController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $instructorRepository;

    public function __construct(InstructorInterface $instructorRepository)
    {

        $this->instructorRepository = $instructorRepository;
    }
    // start addInstitute
    public function addInstitute(Request $request, $id)
    {
        try {
            $data['url'] = route('organization.instructor.store.institute', $id); // url
            $data['title'] = ___('course.Add Education'); // title
            @$data['button'] = ___('common.Submit'); // button
            $html = view('organization::panel.organization.modal.institute.create_institute', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editInstitute($key, $id)
    {
        try {
            $data['institute'] = $this->instructorRepository->model()->where('user_id', decryptFunction($id))->select('education')->first()->education;
            if (@$data['institute'] && @$data['institute'][$key]) {
                $data['url'] = route('organization.instructor.update.institute', [$key, $id]); // url
                $data['title'] = ___('course.Edit Education'); // title
                @$data['button'] = ___('common.Update'); // button
                $data['institute'] = $data['institute'][$key];
                $html = view('organization::panel.organization.modal.institute.edit_institute', compact('data'))->render(); // render view
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
            $result = $this->instructorRepository->addInstitute($request, decryptFunction($id));
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
            $result = $this->instructorRepository->updateInstitute($request, $key, decryptFunction($id));
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
            $result = $this->instructorRepository->deleteInstitute($key, decryptFunction($id));
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
