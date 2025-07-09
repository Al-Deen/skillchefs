<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Role;
use App\Events\AdminEmailVerificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Ambassador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Instructor\Http\Requests\AdminInstructorRequest;
use Modules\Instructor\Http\Requests\InstructorCreate;

class AmbassadorController extends Controller
{
    public function requests(Request $request)
    {
        try {
            $data['ambassadors'] = Ambassador::pending()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('ambassador.Ambassador Request Lists'); // title
            return view('backend.ambassador.request', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function login($id)
    {
        try {
            $data['ambassador'] =Ambassador::where('id', $id)->first(); // data
            if (!$data['ambassador']) {
                return redirect()->back()->with('danger', ___('alert.ambassador_not_found'));
            }
            Auth::loginUsingId($data['ambassador']->user_id);
            return redirect()->route('ambassador.dashboard');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function approve($id)
    {
        try {
            $ambassador = Ambassador::where('id', $id)->first(); // data
            if (!$ambassador) {
                return redirect()->back()->with('danger', ___('alert.ambassador_not_found'));
            }
            $user = $ambassador->user;
            $user->status_id = 4;
            $user->save();
           return redirect()->back()->with('success', ___('alert.Ambassador approved successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function suspend($id)
    {
        try {
            $ambassador =Ambassador::where('id', $id)->first(); // data
            if (!$ambassador) {
                return redirect()->back()->with('danger', ___('alert.ambassador_not_found'));
            }
            $user = $ambassador->user;
            $user->status_id = 5;
            $user->save();
         return redirect()->back()->with('success', ___('alert.Ambassador suspended successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function create()
    {
        try {
            $data['title'] = ___('ambassador.Create Ambassador'); // title
            return view('backend.ambassador.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function store(InstructorCreate $request)
    {

            DB::beginTransaction(); // start database transaction
            try {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    return $this->responseWithError(___('alert.Email already exists'), [], 400);
                }
                $user = new User();
                $user->name = $request->name;
                $user->username = Str::slug($request->name);
                $user->email = $request->email;
                $user->token = Str::random(30);
                $user->password = Hash::make($request->password);
                $user->phone = $request->phone;
                $user->role_id = Role::Ambassador;
                if (auth()->user()->role_id != 5) {
                    $user->status_id = 4;
                    $user->email_verified_at = now();
                    $user->phone_verified_at = now();
                }
                $user->save();

                $ambassador = new Ambassador();
                $ambassador->user_id = $user->id;
                $ambassador->save();
                DB::commit();
                return redirect()->route('admin.ambassador.index')->with('success',___('alert.Ambassador Created Successfully.'));
            } catch (\Throwable $th) {
                DB::rollBack(); // rollback database transaction
                return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
            }
    }

    public function index(Request $request)
    {
        try {
            $data['ambassadors'] =Ambassador::active()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('ambassador.Ambassador Lists'); // title
            return view('backend.ambassador.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function edit($id, $slug)
    {
        try {
            $data['ambassador'] = Ambassador::where('id', $id)->first(); // data
            if (!$data['ambassador']) {
                return redirect()->back()->with('danger', ___('alert.ambassador_not_found'));
            }
            $data['url'] = route('admin.ambassador.update', [$data['ambassador']->id, $slug]); // url']
            $data['title'] = ___('ambassador.Update Ambassador'); // title
            return view('backend.ambassador.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function view($id)
    {
        try {
            $data['ambassador'] = Ambassador::where('id', $id)->first();
            if (!$data['ambassador']) {
                return redirect()->back()->with('danger', ___('alert.ambassador_not_found'));
            }
            $data['title'] = ___('ambassador.Ambassador Information'); // title
            return view('backend.ambassador.view', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }



    public function suspends(Request $request)
    {
        try {
            $data['ambassadors'] = Ambassador::suspended()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('ambassador.Ambassador Suspended Lists'); // title
            return view('backend.ambassador.suspend', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function reActivate($id)
    {
        try {
            $ambassador = Ambassador::where('id', $id)->first(); // data
            if (!$ambassador) {
                return redirect()->back()->with('danger', ___('alert.ambassador_not_found'));
            }
            $user = $ambassador->user;
            $user->status_id = 4;
            $user->save();
            return redirect()->back()->with('success', ___('alert.Ambassador re-activate successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function update(Request $request, $id, $slug)
    {
        try {
            $ambassador = Ambassador::where('id', $id)->first();
            if ($slug == 'general') {
                return $this->updateProfile($request, $ambassador->user_id);
            } elseif ($slug == 'security') {
                return $this->updatePassword($request, $ambassador->user_id);
            } elseif ($slug == 'commission') {
                return $this->updateCommission($request, $ambassador->user_id);
            } else {
                return $this->responseWithError(___('alert.Invalid request.'), [], 400); // return error response
            }
            return redirect()->back()->with('success', ___('alert.Profile updated successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    protected function updateProfile(Request $request, $userId)
    {
        DB::beginTransaction();
        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }

            $ambassador = Ambassador::where('user_id', $userId)->firstOrFail();
            $user = $ambassador->user;

            $ambassador->date_of_birth   = $request->date_of_birth ? date_db_format($request->date_of_birth) : null;
            $ambassador->gender          = $request->gender;
            $ambassador->address         = $request->address;
            $ambassador->country_id      = $request->country_id;
            $ambassador->about_me        = $request->about_me;
            $ambassador->designation     = $request->designation;
            $ambassador->save();

            $user->name         = $request->name;
            $user->phone        = $request->phone;
            $user->facebook_id  = $request->facebook_id;
            $user->linkedin_id  = $request->linkedin_id;
            $user->instagram_id = $request->instagram_id;
            $user->quora_id     = $request->quora_id;

            if ($request->hasFile('profile_image')) {
                $upload = $this->uploadFile($request->profile_image, 'ambassador/profile', [], '', 'image');
                if ($upload['status']) {
                    $user->image_id = $upload['upload_id'];
                } else {
                    return redirect()->back()->with('danger', $upload['message']);
                }
            }

            $user->save();
            DB::commit();

            return redirect()->back()->with('success', ___('alert.Profile updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    protected function updatePassword(Request $request, $userId)
    {
        DB::beginTransaction();
        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }
            $user = User::findOrFail($userId);
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('danger', ___('alert.Old password does not match.'));
            }
            $user->password = Hash::make($request->password);
            $user->save();
            DB::commit();
            return redirect()->back()->with('success', ___('alert.Password updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    protected function updateCommission(Request $request, $userId)
    {
        DB::beginTransaction();

        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }

            // Check if password matches the logged-in user
            if (!Hash::check($request->password, auth()->user()->password)) {
                return redirect()->back()->with('danger', ___('alert.Password does not match.'));
            }

            // Get or create Instructor
            $ambassador =Ambassador::where('user_id',$userId)->first();
            $ambassador->commission = $request->commission;
            $ambassador->save();

            // Update event commission on user
            $user = User::findOrFail($userId);
            $user->event_commission = $request->event_commission;
            $user->save();

            DB::commit();
            return redirect()->back()->with('success', ___('alert.Commission updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }




}
