<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Course\Entities\CourseCategory;

class SelectController extends Controller
{
    // instructor list
    public function instructorList(Request $req)
    {
        return User::whereNotIn('role_id',['4'])->where(['status' => 1])->where('name', 'LIKE', "%$req->term%")->select('id', 'name as text')->take(10)->get();
    }

    // category list
    public function categoriesList(Request $req)
    {
        return CourseCategory::where(['status_id' => 1])->where('title', 'LIKE', "%$req->term%")->select('id', 'title as text')->take(10)->get();
    }
}
