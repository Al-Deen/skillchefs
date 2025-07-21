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
            $data['ambassadors'] =Ambassador::active()->latest()->get();
            return view('frontend.auth.become_ambassador', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function signUp(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return $this->responseWithError(___('alert.Email already exists'), [], 400);
            }

            // Extract main name excluding "Md." or "Md"
            $parts = explode(' ', $request->name);
            $ignoreList = ['md', 'md.'];
            $filtered = array_filter($parts, function ($word) use ($ignoreList) {
                return !in_array(strtolower(trim($word)), $ignoreList);
            });
            $mainName = ucfirst(reset($filtered)) ?? 'Ambassador';

            // Generate username with random 6 digits
            $randomDigits = rand(100000, 999999);
            $username = $mainName . '-' . $randomDigits;

            // Create user
            $user = new User();
            $user->name = $request->name;
            $user->username = $username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->facebook_id = $request->facebook_id;
            $user->linkedin_id = $request->linkedin_id;
            $user->instagram_id = $request->instagram_id;
            $user->quora_id = $request->quora_id;
            $user->role_id = Role::Ambassador;
            $user->save();

            // Save ambassador info
            $questions = $request->input('questions', []);
            $titles = [];
            $answers = [];
            foreach ($questions as $q) {
                $titles[] = $q['title'];
                $answers[] = $q['answer'];
            }

            $ambassador = new Ambassador();
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
            DB::commit();

            return redirect()->route('frontend.signIn')->with('success', 'Ambassador Applied successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
