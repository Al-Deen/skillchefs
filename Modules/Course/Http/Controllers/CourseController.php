<?php

namespace Modules\Course\Http\Controllers;

use App\Interfaces\LanguageInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;

class CourseController extends Controller
{
    // constructor injection
    protected $course;
    protected $courseCategory;
    protected $language;

    public function __construct(
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface
    ) {
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
        $this->language = $languageInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['tableHeader'] = $this->course->tableHeader(); // table header
            $data['params'] = $this->course->params($request); // table header
            $data['courses'] = $this->course->model()->search($request)->paginate($request->show ?? 10); // data
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['title'] = ___('course.Courses'); // title
            return view('course::index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['languages'] = $this->language->all(); // data
            $data['title'] = ___('course.Create Course'); // title
            return view('course::create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CourseRequest $request)
    {
        try {
            $result = $this->course->store($request);
            if ($result->original['result']) {
                return redirect()->route('course.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('course::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['course'] = $this->course->model()->find($id); // data
            $data['title'] = ___('course.Edit Course'); // title
            $data['languages'] = $this->language->all(); // data
            return view('course::edit', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function addContent($id)
    {
        try {
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['course'] = $this->course->model()->find($id); // data
            $data['title'] = ___('course.Edit Course'); // title
            $data['languages'] = $this->language->all(); // data
            return view('course::addContent', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CourseRequest $request, $id)
    {
        try {
            $result = $this->course->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('course.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $result = $this->course->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('course.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function list(Request $req) {
        try {
            return $this->course->model()->active()->where('title', 'LIKE', "%$req->term%")->select('id', 'title as text')->take(10)->get();
        } catch (\Throwable $th) {
        }
    }
}
