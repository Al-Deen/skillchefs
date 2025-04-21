<?php

namespace Modules\CMS\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Http\Requests\DiscountCourseRequest;
use Modules\Course\Interfaces\CourseInterface;

class DiscountCourseController extends Controller
{
    use ApiReturnFormatTrait;

    protected $course;

    public function __construct(CourseInterface $courseInterface)
    {
        $this->course = $courseInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['courses'] = $this->course->model()->search($request->search)->active()->visible()->discount()->latest()->paginate($request->show ?? 10); // data
            $data['title'] = ___('course.Discount Course List'); // title
            return view('cms::discount_course.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function selectCourse(Request $req)
    {
        return $this->course->model()->where(['is_discount' => 10, 'is_free' => 0])->active()->visible()->where('title', 'LIKE', "%$req->term%")->select('id', 'title', 'price')->take(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->title . ' - ' . showPrice($item->price),
            ];
        });
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['title'] = ___('common.Create Discount Course'); // title
            $data['button'] = ___('common.Create');
            $data['url'] = route('admin.discount-course.store');
            $html = view('cms::discount_course.modal.create', compact('data'))->render(); // render view
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
    public function store(DiscountCourseRequest $request)
    {
        try {
            $result = $this->course->courseDiscount($request); // create data
            if ($result->original['result']) {
                return $this->responseWithSuccess(___('alert.Course_discount_added_successfully')); // return success response
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
            $data['course'] = $this->course->show($id); // data
            $data['title'] = ___('common.Update Discount Course'); // title
            $data['button'] = ___('common.Update');
            $data['url'] = route('admin.discount-course.update', $id);
            $html = view('cms::discount_course.modal.create', compact('data'))->render(); // render view
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
    public function update(DiscountCourseRequest $request, $id)
    {
        try {
            $result = $this->course->courseDiscount($request); // update data
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
            $result = $this->course->courseDiscountDestroy($id); // delete data
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
