<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Course\Http\Requests\Instructor\QuestionRequest;
use Modules\Course\Interfaces\LessonInterface;
use Modules\Course\Interfaces\QuestionInterface;
use Modules\Course\Interfaces\QuizResultInterface;

class QuestionController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $question;
    protected $lesson;
    protected $quizResult;

    public function __construct(QuestionInterface $questionInterface, LessonInterface $lessonInterface, QuizResultInterface $quizResultInterface)
    {
        $this->question = $questionInterface;
        $this->lesson = $lessonInterface;
        $this->quizResult = $quizResultInterface;
    }

    public function index(Request $request)
    {
        try {
            $quizzes = $this->lesson->model()
                ->search($request)
                ->where('created_by', auth()->user()->id)
                ->where('is_quiz', 1); // get quizzes
            $data['total_submissions'] = $quizzes->clone()->withCount('submissions')->get()->sum('submissions_count');

            $data['passed_submissions'] = $quizzes->clone()->withCount(['submissions' => function ($query) {
                $query->where('status_id', 25);
            }])->get()->sum('submissions_count');

            $data['failed_submissions'] = $quizzes->clone()->withCount(['submissions' => function ($query) {
                $query->where('status_id', 24);
            }])->get()->sum('submissions_count');

            $data['quizzes'] = $quizzes->clone()->paginate(10); // data
            $data['title'] = ___('course.Course Quizzes List'); // title
            return view('panel.instructor.quiz.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function submission($quiz_id)
    {
        try {
            $data['quizzes'] = $this->lesson->model()->with('submissions')->where('created_by', auth()->user()->id)->where('id', decryptFunction($quiz_id))->first(); // data
            if (!$data['quizzes']) {
                return redirect()->back()->with('danger', ___('alert.Quiz not found'));
            }
            $data['submissions'] = $data['quizzes']->submissions()->latest()->paginate(10);
            $data['title'] = ___('course.Quiz Submissions'); // title
            return view('panel.instructor.quiz.submission', compact('data')); // view
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function view($submission_id)
    {
        try {
            $data['result'] = $this->quizResult->model()->where('id', decryptFunction($submission_id))->first(); // data
            if (!$data['result']) {
                return $this->responseWithError('danger', ___('alert.Quiz not found'));
            }
            $data['title'] = ___('course.Quiz Submission Details'); // title
            // return view('panel.instructor.modal.quiz.view', compact('data'));
            $html = view('panel.instructor.modal.quiz.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($lesson_id)
    {

        try {
            $data['course'] = $this->lesson->model()->where('id', $lesson_id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['course']) {
                return $this->responseWithError(___('alert.Quiz_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.question.store', $lesson_id); // url
            $data['title'] = ___('course.Create Course Question'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.question.create', compact('data'))->render(); // render view
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
    public function store(QuestionRequest $request, $lesson_id)
    {
        try {
            $data['lesson'] = $this->lesson->model()->where('id', $lesson_id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['lesson']) {
                return $this->responseWithError(___('alert.course_lesson_not_found'), [], 400); // return error response
            }
            $request->merge(['course_id' => $data['lesson']->course_id]);
            $request->merge(['lesson_id' => $data['lesson']->id]);
            $request->merge(['title' => $request->question_title]);
            $request->merge(['description' => $request->notice_description]);
            $result = $this->question->store($request);
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
            $data['question'] = $this->question->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['question']) {
                return $this->responseWithError(___('alert.Question_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.question.update', $id); // url
            $data['title'] = ___('course.Edit Course Question'); // title
            @$data['button'] = ___('common.Save');
            $html = view('panel.instructor.modal.question.edit', compact('data'))->render(); // render view
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
    public function update(QuestionRequest $request, $id)
    {
        try {
            $data['question'] = $this->question->model()->where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['question']) {
                return $this->responseWithError(___('alert.Question_not_found'), [], 400); // return error response
            }
            $request->merge(['title' => $request->question_title]);
            $request->merge(['description' => $request->notice_description]);
            $result = $this->question->update($request, $id);
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
            $result = $this->question->sortable($request, $id);
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
            $questionModel = $this->question->model()->find($id);
            if (!$questionModel) {
                return redirect()->back()->with('danger', ___('alert.Question_not_found'));
            }
            $result = $this->question->destroy($id);
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
