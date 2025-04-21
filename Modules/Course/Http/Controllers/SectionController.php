<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Interfaces\SectionInterface;
use Modules\Course\Http\Requests\SectionRequest;

class SectionController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $section;
    protected $course;

    public function __construct(SectionInterface $sectionInterface, CourseInterface $courseInterface)
    {
        $this->section = $sectionInterface;
        $this->course = $courseInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, $id)
    {
        try {
            $data['course'] = $this->course->model()->find($id); // data
            if (!$data['course']) {
                return redirect()->back()->with('danger', ___('alert.course_not_found'));
            }
            $data['tableHeader'] = $this->section->tableHeader(); // table header
            $data['title'] = ___('course.Course Section List'); // title
            $data['sections'] = $this->section->model()->search($request)->orderBy('order','DESC')->paginate($request->show ?? 10); // data
            return view('course::section.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($course_id)
    {
        try {
            $data['course'] = $this->course->model()->find($course_id); // data
            if (!$data['course']) {
                return $this->responseWithError( ___('alert.course_not_found'), [], 400); // return error response
            }
            $data['url'] = route('course.curriculum.store', $course_id); // url
            $data['title'] = ___('course.Create Course Section'); // title
            $data['attributes'] = $this->section->createAttributes();
            @$data['button']   = ___('common.Save');
            $html = view('course::section.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess( ___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SectionRequest $request, $id)
    {
        try {
            $course = $this->course->model()->find($id); // data
            if (!$course) {
                return $this->responseWithError( ___('alert.course_not_found'), [], 400); // return error response
            }
            $request->merge(['course_id' => $id]);
            $result = $this->section->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['section'] = $this->section->model()->find($id); // data
            if (!$data['section']) {
                return $this->responseWithError( ___('alert.course_section_not_found'), [], 400); // return error response
            }
            $data['url'] = route('course.curriculum.update', $id); // url
            $data['title'] = ___('course.Edit Course Section'); // title
            $data['attributes'] = $this->section->editAttributes($data['section']);
            @$data['button']   = ___('common.Update');
            $html = view('course::section.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess( ___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SectionRequest $request, $id)
    {
        try {
            $section = $this->section->model()->find($id); // data
            if (!$section) {
                return $this->responseWithError( ___('alert.course_section_not_found'), [], 400); // return error response
            }
            $result = $this->section->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError( ___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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
            $sectionModal = $this->section->model()->find($id);
            if (!$sectionModal) {
                return redirect()->back()->with('danger', ___('alert.course_section_not_found'));
            }
            $result = $this->section->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
