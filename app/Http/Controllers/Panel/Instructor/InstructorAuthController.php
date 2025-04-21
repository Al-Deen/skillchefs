<?php

namespace App\Http\Controllers\Panel\Instructor;


use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Instructor\Interfaces\InstructorInterface;
use App\Http\Requests\frontend\instructor\InstructorRegistration;

class InstructorAuthController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $instructorRepository;
    public function __construct(InstructorInterface $instructorRepository)
    {
        $this->instructorRepository = $instructorRepository;
    }


    public function becomeInstructor()
    {
        try {
            $data['title']      = ___('frontend.Become An Instructor'); // title
            return view('frontend.auth.become_instructor', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    
    public function signUp(InstructorRegistration $request)
    {
        try {
            $result = $this->instructorRepository->store($request);
            if ($result->original['result']) {
                return redirect()->route('frontend.signIn')->with('email_verify', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
