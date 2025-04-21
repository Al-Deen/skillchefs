<?php

namespace App\Http\Controllers\Panel\Student;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Student\Http\Requests\SkillRequest;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Student\Http\Requests\StudentRequest;
use Modules\Student\Http\Requests\PasswordRequest;
use Modules\Student\Http\Requests\InstituteRequest;

class SettingsController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $studentRepository;
    protected $template = 'panel.student';

    public function __construct(StudentInterface $studentRepository) {
        $this->studentRepository          = $studentRepository;
    }

    public function setting()
    {

        try {
            $data['title']              = ___('student.Student Setting'); // title
            $data['student']            = $this->studentRepository->model()->where('user_id', auth()->user()->id)->first();
            return view($this->template . '.settings', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateProfile(StudentRequest $request)
    {

        try {
            $result = $this->studentRepository->updateProfile($request, auth()->user()->id);
            if ($result->original['result']) {
                return redirect()->route('student.setting', ['edit'])->with('success', $result->original['message']);
            } else {
                return redirect()->route('student.setting', ['edit'])->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('student.setting', ['edit'])->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // start update password
    public function updatePassword(PasswordRequest $request)
    {

        try {
            $result = $this->studentRepository->updatePassword($request, auth()->user());
            if ($result->original['result']) {
                return redirect()->route('student.setting', ['security'])->with('success', $result->original['message']);
            } else {
                return redirect()->route('student.setting', ['security'])->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('student.setting',['security'])->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // end update password


    // start skill
    public function addSkill()
    {

        try {
            $data['url'] = route('student.store.skill'); // url
            $data['title'] = ___('course.Skills'); // title
            @$data['button']   = ___('student.Save & Update'); // button
            $data['student']            = $this->studentRepository->model()->where('user_id', auth()->user()->id)->first();
            $html = view('panel.student.partials.modal.skill.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeSkill(SkillRequest $request){
        try {
            $result = $this->studentRepository->storeSkill($request, auth()->user()->id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }


}
