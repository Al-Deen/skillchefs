<?php

namespace App\Http\Controllers\Panel\Ambassador;

use App\Enums\Role;
use App\Events\UserEmailVerifyEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\instructor\InstructorRegistration;
use App\Models\Ambassador;
use App\Models\AmbassadorSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AmbassadorAuthController extends Controller
{
    public function becomeAmbassador()
    {
        try {
            $data['title']      = ___('frontend.Become An Ambassador');
            $data['ambassador_settings'] = AmbassadorSetting::first();

            return view('frontend.auth.become_ambassador', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function signUp(Request $request)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return $this->responseWithError(___('alert.Email already exists'), [], 400);
            }
            $user_name = preg_replace('/[^A-Za-z0-9]/', '', Str::slug($request->name, '-'));
            $user = new User();
            $user->name = $request->name;
            $user->username = $user_name . '-' . Str::random(5);
            $user->email = $request->email;
            $user->phone = $request->phone;
            //$user->token = Str::random(30);
            $user->password = Hash::make($request->password);
            $user->facebook_id = $request->facebook_id;
            $user->linkedin_id = $request->linkedin_id;
            $user->instagram_id = $request->instagram_id;
            $user->quora_id = $request->quora_id;
            $user->role_id = Role::Ambassador;

            // email otp send
//            $otpVerificationStatus = setting('instructor_otp_verification');
//            if($otpVerificationStatus === "1" || $otpVerificationStatus === "3"){
//                try {
//                    event(new UserEmailVerifyEvent($user));
//                } catch (\Throwable $th) {
//                    $alert = ___('alert.Instructor create but please configure SMTP to send email correctly');
//                }
//                $alert = ___('alert.Please check your email to verify your account.');
//            }
            // sms otp send
//            if($otpVerificationStatus === "2" || $otpVerificationStatus === "3"){
//                $user->token = mt_rand(1111,9999);
//                $user->save();
//                $this->SendSignupOTP(___('alert.Your_OTP_Code_is') . $user->token . ___('This_Code_will_expire_in_15_minutes'), $request->phone);
//                $alert = ___('alert.Please check your mobile to verify phone number.');
//            }
            // no verification
//            if($otpVerificationStatus === "0"){
//                $user->email_verified_at = now();
//                $user->phone_verified_at = now();
//                $user->save();
//            }

            $user->save();


            $questions = $request->input('questions', []);

            $titles = [];
            $answers = [];

            foreach ($questions as $q) {
                $titles[] = $q['title'];
                $answers[] = $q['answer'];
            }

            $ambassador = new Ambassador(); // create new object of model for store data in database table
            $ambassador->university = $request->university;
            $ambassador->graduation_year = $request->graduation_year;
            $ambassador->question_title = json_encode($titles, JSON_UNESCAPED_UNICODE);
            $ambassador->question_answer = json_encode($answers, JSON_UNESCAPED_UNICODE);
            $ambassador->user_id = $user->id;


            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ambassador'), $fileName);
                $ambassador->cv = 'uploads/ambassador/' . $fileName;
            }
            $ambassador->save();
            DB::commit(); // commit database transaction
            return redirect()->route('frontend.signIn')->with('success', 'Ambassador Applied successfully.');
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
