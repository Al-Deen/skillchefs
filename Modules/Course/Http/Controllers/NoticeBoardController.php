<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Interfaces\NoticeboardInterface;
use Modules\Course\Http\Requests\NoticeBoardRequest;

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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, $id)
    {
        try {
            $data['course'] = $this->course->model()->find($id); // data
            if (!$data['course']) {
                return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
            }
            $data['tableHeader'] = $this->noticeBoard->tableHeader(); // table header
            $data['noticeboards'] = $this->noticeBoard->model()->where('course_id', $id)->search($request)->latest()->paginate($request->show ?? 10); // data
            $data['title'] = ___('course.Course NoticeBoard List'); // title
            return view('course::noticeboard.index', compact('data')); // view
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
                return redirect()->back()->with('danger', ___('alert.course_not_found'));
            }
            $data['title'] = ___('course.Create Course NoticeBoard'); // title
            return view('course::noticeboard.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $result = $this->noticeBoard->store($request);
            if ($result->original['result']) {
                return redirect()->route('course.notice-board.index', [$course_id])->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
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
            $noticeBoard = $this->noticeBoard->model()->find($id);
            if (!$noticeBoard) {
                return redirect()->back()->with('danger', ___('alert.notice_board_not_found'));
            }
            $data['course'] = $noticeBoard->course;
            $data['title'] = ___('course.Edit Course NoticeBoard'); // title
            $data['noticeboard'] = $noticeBoard;
            return view('course::noticeboard.edit', compact('data')); // view
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
    public function update(NoticeBoardRequest $request, $id)
    {
        try {

            $noticeBoard = $this->noticeBoard->model()->find($id);
            if (!$noticeBoard) {
                return redirect()->back()->with('danger', ___('alert.notice_board_not_found'));
            }
            $result = $this->noticeBoard->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('course.notice-board.index', [$noticeBoard->course_id])->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
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
            $limit = $request->show_more ?? 10;
            $data['notice_boards'] = $this->noticeBoard->filter(['course_id' => $id])->with('course')->search($request)->latest()->paginate($limit);
            @$data['tableHeader'] = $this->noticeBoard->tableHeader();
            $html               = view('course::ajax.ajax_notice_board', compact('data'))->render();
            return $this->responseWithSuccess(___('alert.Data retrieve successfully.'), $html);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
}
