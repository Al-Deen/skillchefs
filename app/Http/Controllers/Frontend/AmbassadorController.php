<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AmbassadorController extends Controller
{
    public function index(Request $request)
    {

        try {
            $data['title'] = ___('frontend.Instructors'); // title
            $data['instructor'] = $this->instructor->model()->with(['user'])->whereHas('user', function ($query) {
                $query->where('status', 1);
            })->paginate(5);

            if (Cache::has('instructor_categories')) {
                $categories = Cache::get('instructor_categories');
            } else {
                $categories = $this->courseCategory->model()->active()->select('title', 'id')->get();
                Cache::put('instructor_categories', $categories);
            }
            $data['categories'] = $categories;
            if (Cache::has('instructor_languages')) {
                $data['languages'] = Cache::get('instructor_languages');
            } else {
                $data['languages'] = $this->course->model()->select('language')->groupBy('language')->get();
                Cache::put('instructor_languages', $data['languages']);
            }
            return view('frontend.instructor.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
