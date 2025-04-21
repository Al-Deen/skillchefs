<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Interfaces\AssignmentInterface;
use Modules\Course\Http\Requests\AssignmentRequest;
use Modules\Course\Interfaces\AssignmentSubmitInterface;
use Modules\Course\Http\Requests\Instructor\AssignmentSubmitReviewRequest;

class AssignmentController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $assignment;
    protected $course;
    protected $assignmentSubmit;

    public function __construct(AssignmentInterface $assignmentInterface, CourseInterface $courseInterface, AssignmentSubmitInterface $assignmentSubmitInterface)
    {
        $this->assignment = $assignmentInterface;
        $this->course = $courseInterface;
        $this->assignmentSubmit = $assignmentSubmitInterface;
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
            $data['tableHeader'] = $this->assignment->tableHeader(); // table header
            $data['assignments'] = $this->assignment->model()->where('course_id', $id)->search($request)->latest()->paginate($request->show ?? 10); // data
            $data['title'] = ___('course.Course Assignment List'); // title
            return view('course::assignment.index', compact('data')); // view
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
            $data['title'] = ___('course.Create Course Assignment'); // title
            return view('course::assignment.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AssignmentRequest $request, $course_id)
    {
        try {
            $request->merge(['course_id' => $course_id]);
            $result = $this->assignment->store($request);
            if ($result->original['result']) {
                return redirect()->route('course.assignment.index', [$course_id])->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($assignment_id)
    {
        try {
            $assignment = $this->assignment->model()->find($assignment_id);
            if (!$assignment) {
                return redirect()->back()->with('danger', ___('alert.assignment_not_found'));
            }
            $data['course'] = $assignment->course;
            $data['title'] = ___('course.Edit Course Assignment'); // title
            $data['assignment'] = $assignment;
            return view('course::assignment.edit', compact('data')); // view
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
    public function update(AssignmentRequest $request, $id)
    {
        try {
            $result = $this->assignment->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('course.assignment.index', [$request->course_id])->with('success', $result->original['message']);
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
            $result = $this->assignment->destroy($id);
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
    public function ajaxAssignment(Request $request, $id)
    {
        try {
            $limit = $request->show_more ?? 10;
            $data['assignments'] = $this->assignment->filter(['course_id' => $id])->with('course')->search($request)->latest()->paginate($limit);
            @$data['tableHeader'] = $this->assignment->tableHeader();
            $html               = view('course::ajax.ajax_assignment', compact('data'))->render();
            return $this->responseWithSuccess(___('alert.Data retrieve successfully.'), $html);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function assignmentList(Request $request){
        try {
            $limit = $request->show_more ?? 10;
            $assignments = $this->assignment->model()
            ->search($request);
            $data['total_submissions'] = $assignments->clone()->withCount('assignmentSubmit')->get()->sum('assignment_submit_count');
            $data['passed_submissions'] = $assignments->clone()->withCount(['assignmentSubmit' => function ($query) {
                $query->where('status_id', 25);
            }])->get()->sum('assignment_submit_count');
            $data['failed_submissions'] = $assignments->clone()->withCount(['assignmentSubmit' => function ($query) {
                $query->where('status_id', 24);
            }])->get()->sum('assignment_submit_count');

            $data['assignments'] = $assignments->clone()->paginate($limit); // data

            $data['title'] = ___('course.Assignment List'); // title
            return view('course::assignment.assignment_list', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function assignmentSubmissionList($assignment_id)
    {
        try {
            $data['assignment'] = $this->assignment->model()->with('assignmentSubmit')->where('id', $assignment_id)->first(); // data

            if (!$data['assignment']) {
                return redirect()->back()->with('danger', ___('alert.Assignment not found'));
            }
            $data['submissions'] = $data['assignment']->assignmentSubmit()->with('status')->latest()->paginate(10);
            $data['title'] = ___('course.Assignment Submissions'); // title
            return view('course::assignment.submission_list', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function assignmentSubmissionView($assignment_id)
    {
        try {
            $data['assignmentSubmission'] = $this->assignmentSubmit->model()->where('id', $assignment_id)->first(); // data
            if (!$data['assignmentSubmission']) {
                return $this->responseWithError('danger', ___('alert.Assignment not found'));
            }
            $data['url'] = route('admin.assignment.marks', [$assignment_id]); // url
            $data['title'] = ___('course.Assignment Submission Details'); // title
            @$data['button'] = ___('common.Submit');
            $html = view('course::assignment.modal.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function assignmentDownload($assignment_id)
    {
        try {
            $data['assignment'] = $this->assignment->model()->where('id', $assignment_id)->first(); // data
            if (!$data['assignment']) {
                return redirect()->back()->with('danger', ___('alert.Assignment not found'));
            }
            if ($data['assignment']) {
                $file = @$data['assignment']->assignmentFile->original;
                if ($file) {
                    return downloadFile($file); // download file
                } else {
                    return redirect()->back()->with('danger', ___('alert.File not found')); // return error response
                }
            } else {
                return redirect()->back()->with('danger', ___('alert.Assignment not found')); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }
    public function assignmentSubmissionDownload($assignment_submit_id)
    {
        try {
            $data['assignmentSubmission'] = $this->assignmentSubmit->model()->where('id', $assignment_submit_id)->first(); // data
            if (!$data['assignmentSubmission']) {
                return redirect()->back()->with('danger', ___('alert.Assignment submission not found'));
            }
            if ($data['assignmentSubmission']) {
                $file = @$data['assignmentSubmission']->assignmentFile->original;
                if ($file) {
                    return downloadFile($file); // download file
                } else {
                    return redirect()->back()->with('danger', ___('alert.File not found')); // return error response
                }
            } else {
                return redirect()->back()->with('danger', ___('alert.Assignment not found')); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }

    public function marks(AssignmentSubmitReviewRequest $request, $assignment_submit_id)
    {
        try {
            $result = $this->assignmentSubmit->review($request, encryptFunction($assignment_submit_id));
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }

    }
}
