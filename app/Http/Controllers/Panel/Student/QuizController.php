<?php

namespace App\Http\Controllers\Panel\Student;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Interfaces\QuestionInterface;
use Modules\Course\Interfaces\QuestionSubmitInterface;
use Modules\Course\Interfaces\QuizInterface;
use Modules\Course\Interfaces\QuizResultInterface;
use Modules\Order\Interfaces\EnrollInterface;

class QuizController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $enrollRepository;
    protected $questionRepository;
    protected $quizRepository;
    protected $questionSubmitRepository;
    protected $quizResultRepository;

    protected $template = 'panel.student';

    public function __construct(
        EnrollInterface $enrollRepository,
        QuestionInterface $questionRepository,
        QuizInterface $quizRepository,
        QuizResultInterface $quizResultRepository,
        QuestionSubmitInterface $questionSubmitRepository
    ) {
        $this->enrollRepository = $enrollRepository;
        $this->questionRepository = $questionRepository;
        $this->quizRepository = $quizRepository;
        $this->questionSubmitRepository = $questionSubmitRepository;
        $this->quizResultRepository = $quizResultRepository;
    }

    public function quiz($lessonId)
    {
        try {
            $lesson_id = decryptFunction($lessonId);
            $enroll = $this->enrollRepository->model()->where('user_id', Auth::id())->whereHas('lessons', function ($q) use ($lesson_id) {
                $q->where('id', $lesson_id);
            })->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.course_not_found'), [], 200); // return error response
            }
            $data['quiz_result'] = $this->quizResultRepository->model()->where('user_id', Auth::id())->where('enroll_id', $enroll->id)->where('quiz_id', $lesson_id)->first();
            if ($data['quiz_result'] && $data['quiz_result']->is_submitted == 11 || in_array($lesson_id, $enroll->completed_quizzes ?? [])) {
                $data['result'] = $data['quiz_result'];                
                $html = view('panel.student.course.quiz.answer_list', compact('data'))->render(); // render view
                $info['html'] = $html;
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // return success response
            }
            $data['url'] = route('student.quiz.start', $lessonId);
            $data['quiz'] = $this->quizRepository->model()->where('id', $lesson_id)->first();
            $data['title'] = ___('student.Student Quiz'); // title
            $html = view('panel.student.course.quiz.index', compact('data'))->render(); // render view
            $info['html'] = $html;
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function quizStart($lessonId)
    {
        try {
            $lesson_id = decryptFunction($lessonId);
            $enroll = $this->enrollRepository->model()->where('user_id', Auth::id())->whereHas('lessons', function ($q) use ($lesson_id) {
                $q->where('id', $lesson_id);
            })->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.course_not_found'), [], 200); // return error response
            }
            $data['quiz'] = $this->quizRepository->model()->where('id', $lesson_id)->first();
            $result = $this->quizResultRepository->store(['quiz_id' => $lesson_id, 'enroll_id' => $enroll->id]);
            if (!$result->original['result']) {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            } else if ($result->original['data']->is_submitted == 11) {
                $data['result'] = $result->original['data'];
                $html = view('panel.student.course.quiz.answer_list', compact('data'))->render(); // render view
                $info['html'] = $html;
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // return success response
            }
            $data['questions'] = $this->questionRepository->model()->where('quiz_id', $lesson_id)->paginate(1);
            $data['quiz_result_id'] = encryptFunction($result->original['data']->id);
            $html = view('panel.student.course.quiz.start', compact('data'))->render(); // render view
            $info['html'] = $html;
            $info['quiz_start'] = 1;
            if (!$data['quiz']->is_timer) {
                $info['time'] = $data['quiz']->duration;
            }
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function questionLoad(Request $request, $quiz_id)
    {
        try {
            $quiz_id = decryptFunction($quiz_id);
            $data['questions'] = $this->questionRepository->model()->where('quiz_id', $quiz_id)->paginate(1);
            $data['result'] = $this->quizResultRepository->model()->where('quiz_id', $quiz_id)->where('user_id', Auth::id())->first();
            if (@$request->page == ($data['questions']->lastPage() + 1) || @$data['result']->is_submitted == 11) {
                $html = view('panel.student.course.quiz.answer_list', compact('data'))->render(); // render view
                $info['html'] = $html;
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // return success response
            } else {
                $info['html'] = view('panel.student.course.quiz.question_list', compact('data'))->render();
            }
            $info['total'] = $data['questions']->total();
            $info['question_number'] = $data['questions']->firstItem() . ' / ' . $data['questions']->total();
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // re
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function quizSubmit(Request $request)
    {
        try {
            $data['user_id'] = Auth::id();
            $data['quiz_id'] = decryptFunction($request->quiz_id);
            $data['question_id'] = decryptFunction($request->question_id);
            $data['answer'] = json_encode($request->answer);
            $data['lastQuestion'] = $request->lastQuestion;
            $quiz_result = $this->quizResultRepository->model()->where('id', $data['quiz_id'])->first();
            if ($quiz_result->is_submitted == 11) {
                return $this->responseWithSuccess(___('alert.data_retrieve_success')); // re
            }
            $result = $this->questionSubmitRepository->store($data);
            if ($result->original['result']) {
                return $this->responseWithSuccess(___('alert.data_retrieve_success')); // re
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function answerList(Request $request, $quiz_id)
    {
        try {
            $quiz_id = decryptFunction($quiz_id);
            $data['questions'] = $this->questionRepository->model()->where('quiz_id', $quiz_id)->paginate(1);
            $data['result'] = $this->quizResultRepository->model()->where('quiz_id', $quiz_id)->where('user_id', Auth::id())->first();
            $html = view('panel.student.course.quiz.answer_list', compact('data'))->render(); // render view
            $info['html'] = $html;
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $info); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function questionUp($quiz_id)
    {
        try {
            $quiz_id = decryptFunction($quiz_id);
            $quiz_result = $this->quizResultRepository->model()->where('id', $quiz_id)->first();
            $quiz_result->is_submitted = 11;
            if (floatval($quiz_result->quiz->pass_marks) <= floatval($quiz_result->marks)) {
                $quiz_result->status_id = 25;
            } else {
                $quiz_result->status_id = 24;
            }
            $quiz_result->save();
            return $this->responseWithSuccess(___('alert.data_retrieve_success')); // re
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
