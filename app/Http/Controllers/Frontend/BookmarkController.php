<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Interfaces\BookmarkInterface;

class BookmarkController extends Controller
{
    use ApiReturnFormatTrait;

    protected $bookmarkRepository;
    protected $template = 'panel.student';

    public function __construct(
        BookmarkInterface $bookmarkRepository
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
    }
    // course bookmark
    public function bookmark(Request $request)
    {
        try {
            $data['bookmarks'] = $this->bookmarkRepository->model()->where('user_id', Auth::id())
                ->with('course:id,title,course_duration,course_category_id,slug,price,thumbnail,created_by,rating,total_review')
                ->search($request)
                ->latest()
                ->paginate(10);
            $data['title'] = ___('student.Bookmark Courses'); // title
            if (auth()->user()->role_id == \App\Enums\Role::STUDENT) {
                return view($this->template . '.bookmarks', compact('data'));
            } elseif (auth()->user()->role_id == \App\Enums\Role::INSTRUCTOR) {
                return view('panel.instructor.bookmarks', compact('data'));
            } elseif (auth()->user()->role_id == \App\Enums\Role::ORGANIZATION) {
                return view('organization::panel.organization.frontend.bookmarks', compact('data'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function bookmarkStore($course_id)
    {
        try {
            $result = $this->bookmarkRepository->store($course_id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function bookmarkRemove($course_id)
    {
        try {
            $course_id = decryptFunction($course_id);
            $result = $this->bookmarkRepository->destroy($course_id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    // course bookmark
}
