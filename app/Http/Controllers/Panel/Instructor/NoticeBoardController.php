<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Course\Http\Requests\Instructor\NoticeBoardRequest;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Interfaces\NoticeboardInterface;

class NoticeBoardController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $noticeBoard;
    protected $course;

    public function __construct(NoticeboardInterface $NoticeboardInterface, CourseInterface $courseInterface)
    {
        $this->noticeBoard = $NoticeboardInterface;
        $this->course = $courseInterface;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($course_id)
    {

        try {
            $data['course'] = $this->course->model()->where('id', $course_id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['course']) {
                return $this->responseWithError(___('alert.course_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.noticeboard.store', $course_id); // url
            $data['title'] = ___('course.Create Course NoticeBoard'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.noticeboard.create', compact('data'))->render(); // render view
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
    public function store(NoticeBoardRequest $request, $course_id)
    {
        try {
            $request->merge(['course_id' => $course_id]);
            $request->merge(['title' => $request->notice_title]);
            $request->merge(['description' => $request->notice_description]);
            $result = $this->noticeBoard->store($request);
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
            $data['noticeboard'] = $this->noticeBoard->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['noticeboard']) {
                return $this->responseWithError(___('alert.notice_board_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.noticeboard.update', $id); // url
            $data['title'] = ___('course.Edit Course NoticeBoard'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.noticeboard.edit', compact('data'))->render(); // render view
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
    public function update(NoticeBoardRequest $request, $id)
    {
        try {
            $request->merge(['title' => $request->notice_title]);
            $request->merge(['description' => $request->notice_description]);
            $noticeBoard = $this->noticeBoard->model()->find($id);
            if (!$noticeBoard) {
                return redirect()->back()->with('danger', ___('alert.notice_board_not_found'));
            }
            $result = $this->noticeBoard->update($request, $id);
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
            $noticeBoard = $this->noticeBoard->model()->find($id);
            if (!$noticeBoard) {
                return redirect()->back()->with('danger', ___('alert.notice_board_not_found'));
            }
            $result = $this->noticeBoard->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show ajax request for the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function ajaxNoticeBoard(Request $request, $id)
    {
        try {
            $data['notice_boards'] = $this->noticeBoard->filter(['course_id' => $id])->with('course')->search($request)->latest()->paginate(2);
            @$data['tableHeader'] = $this->noticeBoard->tableHeader();
            $html = view('panel.instructor.ajax.course.noticeboard', compact('data'))->render();
            return $this->responseWithSuccess(___('alert.Data retrieve successfully.'), $html);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
}
