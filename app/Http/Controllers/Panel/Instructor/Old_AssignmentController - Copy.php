<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Course\Http\Requests\Instructor\AssignmentRequest;
use Modules\Course\Http\Requests\Instructor\AssignmentSubmitReviewRequest;
use Modules\Course\Interfaces\AssignmentInterface;
use Modules\Course\Interfaces\AssignmentSubmitInterface;
use Modules\Course\Interfaces\CourseInterface;

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
    public function index(Request $request)
    {
        try {
            $assignments = $this->assignment->model()
                ->where('created_by', auth()->user()->id)
                ->search($request);
            $data['total_submissions'] = $assignments->clone()->withCount('assignmentSubmit')->get()->sum('assignment_submit_count');
            $data['passed_submissions'] = $assignments->clone()->withCount(['assignmentSubmit' => function ($query) {
                $query->where('status_id', 25);
            }])->get()->sum('assignment_submit_count');
            $data['failed_submissions'] = $assignments->clone()->withCount(['assignmentSubmit' => function ($query) {
                $query->where('status_id', 24);
            }])->get()->sum('assignment_submit_count');

            $data['assignments'] = $assignments->clone()->paginate(10); // data
            $data['title'] = ___('course.Course Assignment List'); // title
            return view('panel.instructor.assignment.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function submission($assignment_id)
    {
        try {
            $data['assignment'] = $this->assignment->model()->with('assignmentSubmit')->where('created_by', auth()->user()->id)->where('id', decryptFunction($assignment_id))->first(); // data
            if (!$data['assignment']) {
                return redirect()->back()->with('danger', ___('alert.Assignment not found'));
            }
            $data['submissions'] = $data['assignment']->assignmentSubmit()->with('status')->latest()->paginate(10);
            $data['title'] = ___('course.Assignment Submissions'); // title
            return view('panel.instructor.assignment.submission', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function review($assignment_id)
    {
        try {
            $data['assignmentSubmission'] = $this->assignmentSubmit->model()->where('id', decryptFunction($assignment_id))->first(); // data
            if (!$data['assignmentSubmission']) {
                return $this->responseWithError('danger', ___('alert.Assignment not found'));
            }
            $data['url'] = route('instructor.assignment.marks', [$assignment_id]); // url
            $data['title'] = ___('course.Assignment Submission Details'); // title
            @$data['button'] = ___('common.Submit');
            $html = view('panel.instructor.modal.assignment.review', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function assignmentDownload($assignment_id)
    {
        try {
            $data['assignment'] = $this->assignment->model()->where('created_by', auth()->user()->id)->where('id', decryptFunction($assignment_id))->first(); // data
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
            $data['assignmentSubmission'] = $this->assignmentSubmit->model()->where('id', decryptFunction($assignment_submit_id))->first(); // data
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
            $result = $this->assignmentSubmit->review($request, $assignment_submit_id);
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
            $data['url'] = route('instructor.assignment.store', $course_id); // url
            $data['title'] = ___('course.Create Course Assignment'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.assignment.create', compact('data'))->render(); // render view
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
    public function store(AssignmentRequest $request, $course_id)
    {
        try {
            $request->merge(['course_id' => $course_id]);
            $request->merge(['title' => $request->assignment_title]);
            $result = $this->assignment->store($request);
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
            $data['assignment'] = $this->assignment->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['assignment']) {
                return $this->responseWithError(___('alert.course_assignment_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.assignment.update', $id); // url
            $data['title'] = ___('course.Edit Course Assignment'); // title
            @$data['button'] = ___('common.Update');
            $html = view('panel.instructor.modal.assignment.edit', compact('data'))->render(); // render view
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
    public function update(AssignmentRequest $request, $id)
    {
        try {
            $request->merge(['title' => $request->assignment_title]);
            $result = $this->assignment->update($request, $id);
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
            Session::put('course_step', 2);
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
            $data['assignments'] = $this->assignment->filter(['course_id' => $id])->with('course')->latest()->paginate(10);
            @$data['tableHeader'] = $this->assignment->tableHeader();
            $html = view('panel.instructor.ajax.course.assignment', compact('data'))->render();
            return $this->responseWithSuccess(___('alert.Data retrieve successfully.'), $html);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
}
