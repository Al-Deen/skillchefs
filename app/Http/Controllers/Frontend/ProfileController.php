<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;

class ProfileController extends Controller
{
    use ApiReturnFormatTrait;

    protected $user;

    // constructor injection
    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function profile($username)
    {
        try {
            $data['title'] = ___('instructor.profile'); // title
            $user = $this->user->query()->where('username', $username)->first();
            if ($user && $user->instructor) {
                $data['instructor'] = $user->instructor;
                return view('frontend.profile.instructor', compact('data'));
            } else if (@$user && $user->student) {
                $data['student'] = $user->student;
                return view('frontend.profile.student', compact('data'));
            } else {
                return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
            }
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
