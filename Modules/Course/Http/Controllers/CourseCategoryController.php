<?php

namespace Modules\Course\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CourseCategoryRequest;
use Modules\Course\Http\Requests\PopularCourseCategoryRequest;
use Modules\Course\Http\Requests\UpdateCourseCategoryRequest;
use Modules\Course\Interfaces\CourseCategoryInterface;

class CourseCategoryController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $courseCategory;

    public function __construct(CourseCategoryInterface $courseCategory)
    {
        $this->courseCategory = $courseCategory;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['categories'] = $this->courseCategory->model()->search($request->search)->paginate($request->show ?? 10); // data
            $data['title'] = ___('course.Course Category'); // title
            return view('course::course_category.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    function list(Request $req) {
        try {
            return $this->courseCategory->model()->where('is_popular', '!=', 1)->active()->where('title', 'LIKE', "%$req->term%")->select('id', 'title as text')->take(10)->get();
        } catch (\Throwable $th) {
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        try {
            $data['title'] = ___('course.Create Course Category'); // title
            $data['categories'] = $this->courseCategory->model()->where('parent_id', null)->get(); // data
            $data['button'] = ___('common.create'); // button
            return view('course::course_category.create', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('course-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CourseCategoryRequest $request)
    {
        try {
            $result = $this->courseCategory->store($request);
            if ($result->original['result']) {
                return redirect()->route('course-category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course-category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('course-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $data['title'] = ___('course.Edit Course Category'); // title
            $data['categories'] = $this->courseCategory->model()->where('parent_id', null)->get(); // data
            $data['button'] = ___('common.update'); // button
            $data['category'] = $this->courseCategory->model()->find($id);
            return view('course::course_category.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('course-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCourseCategoryRequest $request, $id)
    {
        try {
            $result = $this->courseCategory->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('course-category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course-category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('course-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $result = $this->courseCategory->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('course-category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course-category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('course-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function popular(Request $request)
    {
        try {
            $data['categories'] = $this->courseCategory->model()->search($request->search)->popular()->paginate($request->show ?? 10); // data
            $data['title'] = ___('course.Popular Course Category'); // title
            return view('course::course_category.popular', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function popularCreated()
    {
        try {
            $data['title'] = ___('common.Create_Popular_Course'); // title
            $data['button'] = ___('common.Create');
            $data['url'] = route('popular-course-category.store');
            $html = view('course::course_category.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function popularStore(PopularCourseCategoryRequest $request)
    {
        try {
            $result = $this->courseCategory->popularStatus($request->course_id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], [], 200);
            } else {
                return $this->responseWithError($result->original['message'], [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function popularDelete($id)
    {
        try {
            $result = $this->courseCategory->popularStatus($id);
            if ($result->original['result']) {
                return redirect()->route('course-category.popular')->with('success', $result->original['message']);
            } else {
                return redirect()->route('course-category.popular')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('course-category.popular')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
