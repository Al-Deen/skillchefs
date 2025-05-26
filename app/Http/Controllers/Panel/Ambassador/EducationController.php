<?php

namespace App\Http\Controllers\Panel\Ambassador;

use App\Http\Controllers\Controller;
use App\Models\Ambassador;
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
    public function addInstitute(Request $request)
    {

        try {
            $data['url'] = route('ambassador.store.institute'); // url
            $data['title'] = ___('course.Add Education'); // title
            @$data['button'] = ___('common.Submit'); // button
            $html = view('panel.ambassador.modal.institute.create_institute', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function editInstitute($key)
    {

        try {
            $id = auth()->user()->id;

            $data['institute'] = Ambassador::where('user_id', $id)->select('education')->first()->education;
            if (@$data['institute'] && @$data['institute'][$key]) {
                $data['url'] = route('ambassador.update.institute', [$key, $id]); // url
                $data['title'] = ___('course.Edit Education'); // title
                @$data['button'] = ___('common.Update'); // button
                $data['institute'] = $data['institute'][$key];
                $html = view('panel.ambassador.modal.institute.edit_institute', compact('data'))->render(); // render view
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
           $id =  auth()->user()->id;
            $ambassador = Ambassador::where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$ambassador) {
                $ambassador = new Ambassador();
                $ambassador->user_id = $id;
                $ambassador->save();
            }

            $educationArr = [];
            $educations = $ambassador->education ?? [];
            if ($request->name) {
                $educationArr = [
                    'name' => $request->name,
                    'program' => $request->program,
                    'degree' => $request->degree,
                    'current' => $request->current ? 1 : 0,
                    'start_date' => $request->start_date,
                    'end_date' => $request->current ? null : $request->end_date,
                    'description' => $request->description,
                ];
                array_push($educations, $educationArr);
            }
            $ambassador->education = $educations;
            $ambassador->save(); // save data in database table

         return $this->responseWithSuccess('Ambassador institute added successfully'); // return success response

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function updateInstitute(InstituteRequest $request, $key)
    {

        try {
            $id = auth()->user()->id;
            $ambassador =Ambassador::where('user_id', $id)->first(); // create new object of model for store data in database table
            if (!@$ambassador) {
                return $this->responseWithError(___('alert.Ambassador institute not found.'), [], 400);
            }

            $educations = $ambassador->education ?? [];
            if ($request->name) {
                $educations[$key] = [
                    'name' => $request->name,
                    'program' => $request->program,
                    'degree' => $request->degree,
                    'current' => $request->current ? 1 : 0,
                    'start_date' => $request->start_date,
                    'end_date' => $request->current ? null : $request->end_date,
                    'description' => $request->description,
                ];
            }
            $ambassador->education = $educations;
            $ambassador->save(); // save data in database table

            return $this->responseWithSuccess('Ambassador institute updated successfully'); // return success response

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function deleteInstitute($key)
    {

        try {
            $ambassador = Ambassador::where('user_id', auth()->user()->id)->first(); // create new object of model for store data in database table
            if (!@$ambassador) {
                return $this->responseWithError(___('alert.Ambassador institute not found.'), [], 400);
            }

            $educations = $ambassador->education ?? [];
            if (isset($educations[$key])) {
                unset($educations[$key]);
            }
            $ambassador->education = $educations;
            $ambassador->save(); // save data in database table

          return redirect()->route('ambassador.setting', ['educations'])->with('success', 'Ambassador institute deleted successfully'); // return success response

        } catch (\Throwable $th) {
            return redirect()->route('ambassador.setting', ['educations'])->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    // end addInstitute
}
