<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Modules\Instructor\Http\Requests\InstructorRequest;
use Modules\Instructor\Http\Requests\PasswordRequest;
use Modules\Instructor\Http\Requests\SkillRequest;
use Modules\Instructor\Interfaces\InstructorInterface;

class SettingsController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $instructorRepository;
    protected $template = 'panel.instructor';

    public function __construct(InstructorInterface $instructorRepository)
    {

        $this->instructorRepository = $instructorRepository;
    }

    public function setting()
    {
        try {
            $data['user'] = auth()->user(); // data
            $data['title'] = ___('instructor.instructor Setting'); // title
            $data['instructor'] = $this->instructorRepository->model()->where('user_id', auth()->user()->id)->first();
            return view($this->template . '.settings', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateProfile(InstructorRequest $request)
    {
        try {
            $result = $this->instructorRepository->updateProfile($request, auth()->user()->id);
            if ($result->original['result']) {
                return redirect()->route('instructor.setting', ['edit'])->with('success', $result->original['message']);
            } else {
                return redirect()->route('instructor.setting', ['edit'])->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('instructor.setting', ['edit'])->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // start update password
    public function updatePassword(PasswordRequest $request)
    {
        try {
            $result = $this->instructorRepository->updatePassword($request, auth()->user());
            if ($result->original['result']) {
                return redirect()->route('instructor.setting', ['security'])->with('success', $result->original['message']);
            } else {
                return redirect()->route('instructor.setting', ['security'])->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('instructor.setting', ['security'])->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // end update password

    // start skill
    public function addSkill()
    {

        try {
            $data['url'] = route('instructor.store.skill'); // url
            $data['title'] = ___('course.Skills'); // title
            @$data['button'] = ___('instructor.Save & Update'); // button
            $data['instructor'] = $this->instructorRepository->model()->where('user_id', auth()->user()->id)->first();
            $html = view('panel.instructor.modal.skill.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeSkill(SkillRequest $request)
    {
        try {
            $result = $this->instructorRepository->storeSkill($request, auth()->user()->id);
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
