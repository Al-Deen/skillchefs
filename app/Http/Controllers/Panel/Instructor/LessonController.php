<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Course\Http\Requests\Instructor\LessonRequest;
use Modules\Course\Http\Requests\Instructor\UpdateLessonRequest;
use Modules\Course\Interfaces\LessonInterface;
use Modules\Course\Interfaces\SectionInterface;

class LessonController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $lesson;
    protected $section;

    public function __construct(LessonInterface $lessonInterface, SectionInterface $sectionInterface)
    {
        $this->lesson = $lessonInterface;
        $this->section = $sectionInterface;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($section_id)
    {
        try {
            $data['section'] = $this->section->model()->where('id', $section_id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['section']) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.lesson.store', $section_id); // url
            $data['title'] = ___('course.Create Lesson'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.lesson.create', compact('data'))->render(); // render view
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
    public function store(LessonRequest $request, $section_id)
    {

        try {
            $data['section'] = $this->section->model()->where('id', $section_id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['section']) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400); // return error response
            }
            $request->merge(['title' => $request->lesson_title]);
            $request->merge(['video_url' => $request->lesson_video_url]);
            $request->merge(['section_id' => $section_id]);
            $request->merge(['course_id' => $data['section']->course_id]);
            $result = $this->lesson->store($request);
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
            $data['lesson'] = $this->lesson->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['lesson']) {
                return $this->responseWithError(___('alert.course_lesson_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.lesson.update', $id); // url
            $data['title'] = ___('course.Edit Lesson'); // title
            @$data['button'] = ___('common.Update');
            $html = view('panel.instructor.modal.lesson.edit', compact('data'))->render(); // render view
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
    public function update(UpdateLessonRequest $request, $id)
    {
        try {
            $request->merge(['title' => $request->lesson_title]);
            $request->merge(['video_url' => $request->lesson_video_url]);
            $result = $this->lesson->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function sortable(Request $request, $id)
    {
        try {
            $result = $this->lesson->sortable($request, $id);
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
            $result = $this->lesson->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            // return error response
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
