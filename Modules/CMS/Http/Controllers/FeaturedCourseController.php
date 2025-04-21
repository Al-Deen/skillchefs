<?php

namespace Modules\CMS\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Http\Requests\FeaturedCourseRequest;
use Modules\CMS\Interfaces\FeaturedCourseInterface;
use Modules\Course\Interfaces\CourseInterface;

class FeaturedCourseController extends Controller
{
    use ApiReturnFormatTrait;

    protected $featuredCourse;
    protected $course;

    public function __construct(FeaturedCourseInterface $featuredCourseInterface, CourseInterface $courseInterface)
    {
        $this->featuredCourse = $featuredCourseInterface;
        $this->course = $courseInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['courses'] = $this->featuredCourse->model()->search($request->search)->latest()->paginate($request->show ?? 10); // data
            $data['title'] = ___('course.Featured Course List'); // title
            return view('cms::featured_course.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function selectCourse(Request $req)
    {
        return $this->course->model()->whereNotIn('id', $this->featuredCourse->model()->pluck('course_id'))->active()->visible()->where('title', 'LIKE', "%$req->term%")->select('id', 'title as text')->take(10)->get();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['title'] = ___('common.Create Featured Course'); // title
            $data['button'] = ___('common.Create');
            $data['url'] = route('admin.featured-course.store');
            $html = view('cms::featured_course.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FeaturedCourseRequest $request)
    {
        try {
            $result = $this->featuredCourse->store($request); // create data
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return success response
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['featured_course'] = $this->featuredCourse->model()->find($id); // find data
            if (!$data['featured_course']) {
                return $this->responseWithError(___('alert.Featured_course_not_found'), [], 400); // return error response
            }
            $data['title'] = ___('common.Edit Featured Course'); // title
            $data['button'] = ___('common.Update');
            $data['url'] = route('admin.featured-course.update', $id);
            $html = view('cms::featured_course.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FeaturedCourseRequest $request, $id)
    {
        try {
            $result = $this->featuredCourse->update($request, $id); // update data
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return success response
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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
            $result = $this->featuredCourse->destroy($id); // delete data

            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return success response
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
