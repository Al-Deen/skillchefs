<?php

namespace App\Http\Controllers\Panel\Ambassador;

use App\Http\Controllers\Controller;
use App\Models\Ambassador;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\Hash;
use Modules\Instructor\Http\Requests\InstructorRequest;
use Modules\Instructor\Http\Requests\PasswordRequest;
use Modules\Instructor\Http\Requests\SkillRequest;
use Modules\Instructor\Interfaces\InstructorInterface;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $instructorRepository;
    protected $template = 'panel.ambassador';

    public function __construct(InstructorInterface $instructorRepository)
    {

        $this->instructorRepository = $instructorRepository;
    }

    public function setting()
    {
        try {
            $data['user'] = auth()->user(); // data
            $data['title'] = 'Ambassador Setting'; // title
            $data['ambassador'] = Ambassador::where('user_id', auth()->user()->id)->first();
            return view($this->template . '.settings', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateProfile( Request $request)
    {
        try {

            $ambassador = Ambassador::where('user_id', auth()->user()->id)->first(); // create new object of model for store data in database table
            $ambassador->date_of_birth = date_db_format($request->date_of_birth);
            $ambassador->gender = $request->gender;
            $ambassador->address = $request->address;
            $ambassador->country_id = $request->country_id;
            $ambassador->about_me = $request->about_me;
            $ambassador->designation = $request->designation;
            $ambassador->save(); // save data in database table

            $user = $ambassador->user;

            if ($request->hasFile('profile_image')) {
                $upload = $this->uploadFile($request->profile_image, 'ambassador/profile', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $user->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();

            return redirect()->route('ambassador.setting', ['edit'])->with('success', 'Profile updated successfully');

        } catch (\Throwable $th) {

            return redirect()->route('ambassador.setting', ['edit'])->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // start update password
    public function updatePassword(PasswordRequest $request)
    {
        try {
           $user =  auth()->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return $this->responseWithError(___('alert.Old password does not match.'), [], 400);
            }
            $user->password = Hash::make($request->password);
            $user->save();
           return redirect()->route('ambassador.setting', ['security'])->with('success', 'Password updated successfully');

        } catch (\Throwable $th) {
            return redirect()->route('ambassador.setting', ['security'])->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
