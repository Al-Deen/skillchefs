<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Course\Http\Requests\Instructor\SectionRequest;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Interfaces\SectionInterface;

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
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($slug)
    {
        try {
            $data['course'] = $this->course->model()->where('slug', $slug)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['course']) {
                return $this->responseWithError(___('alert.course_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.section.store', $slug); // url
            $data['title'] = ___('course.Create Course Section'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.section.create', compact('data'))->render(); // render view
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
    public function store(SectionRequest $request, $slug)
    {
        try {
            $course = $this->course->model()->where('slug', $slug)->first(); // data
            if (!$course) {
                return $this->responseWithError(___('alert.course_not_found'), [], 400); // return error response
            }
            $request->merge(['title' => $request->section_title]);
            $request->merge(['status' => $request->section_status]);
            $request->merge(['course_id' => $course->id]);
            $result = $this->section->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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
            $data['section'] = $this->section->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['section']) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.section.update', $id); // url
            $data['title'] = ___('course.Edit Course Section'); // title
            @$data['button'] = ___('common.Update');
            $html = view('panel.instructor.modal.section.edit', compact('data'))->render(); // render view
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
    public function update(SectionRequest $request, $id)
    {
        try {
            $section = $this->section->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$section) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400); // return error response
            }
            $request->merge(['title' => $request->section_title]);
            $request->merge(['status' => $request->section_status]);
            $result = $this->section->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function sortable(Request $request, $id)
    {
        try {
            $result = $this->section->sortable($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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
