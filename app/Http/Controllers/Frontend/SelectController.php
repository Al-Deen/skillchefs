<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Course\Entities\CourseCategory;

class SelectController extends Controller
{
    use ApiReturnFormatTrait;
    // instructor list
    public function countryList(Request $req)
    {
        try {
            return Country::where('name', 'LIKE', "%$req->term%")->select('id', 'name as text')->take(10)->get();
        } catch (\Throwable $th) {
        }
    }

    // instructor list
    public function instructorList(Request $req)
    {
        return User::whereNotIn('role_id', ['4'])->where(['status' => 1])->where('name', 'LIKE', "%$req->term%")->select('id', 'name as text')->take(10)->get();
    }

    // category list
    public function categoriesList(Request $req)
    {
        return CourseCategory::where(['status_id' => 1])->where('title', 'LIKE', "%$req->term%")->select('id', 'title as text')->take(10)->get();
    }

    public function changeLanguage(Request $request)
    {
        $path = base_path('lang/' . $request->code);
        if (is_dir($path)) {
            $lang = Language::where('code', $request->code)->select('direction')->first();
            if (@$lang->direction == 'rtl') {
                Session::put('rtl', true);
            } else {
                Session::put('rtl', false);
            }
            Session::put('locale', $request->code);
            return $this->responseWithSuccess(___('alert.language_change_successfully'));
        }
        return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));

    }
}
