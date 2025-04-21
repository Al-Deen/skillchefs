<?php

namespace Modules\Course\Http\Controllers;

use App\Enums\LessonEnum;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Course\Interfaces\QuizInterface;
use Modules\Course\Http\Requests\QuizRequest;
use Modules\Course\Http\Requests\LessonRequest;
use Modules\Course\Interfaces\SectionInterface;
use Modules\Course\Http\Requests\UpdateLessonRequest;

class QuizController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $quiz;
    protected $section;

    public function __construct(QuizInterface $quizInterface, SectionInterface $sectionInterface)
    {
        $this->quiz = $quizInterface;
        $this->section = $sectionInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, $id)
    {
        try {
            $data['section'] = $this->section->model()->find($id); // data
            if (!$data['section']) {
                return redirect()->back()->with('danger', ___('alert.course_section_not_found'));
            }
            $data['tableHeader'] = $this->quiz->tableHeader(); // table header
            $data['title'] = ___('course.Course Quiz List'); // title
            $filter = ['is_quiz' => 1];
            if ($id) $filter[] = ['section_id', $id];     
            $data['quizzes'] = $this->quiz->filter($filter)->search($request)->orderBy('order', 'DESC')->paginate($request->show ?? 10); // data
            return view('course::quiz.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($section_id)
    {
        try {
            $data['section'] = $this->section->model()->find($section_id); // data
            if (!$data['section']) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400); // return error response
            }
            $data['url'] = route('course.quiz.store', $section_id); // url
            $data['title'] = ___('course.Create Quiz'); // title
            @$data['button']   = ___('common.Save');
            $html = view('course::quiz.modal.create', compact('data'))->render(); // render view
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
    public function store(QuizRequest $request, $section_id)
    {

        try {
            $data['section'] = $this->section->model()->find($section_id); // data
            if (!$data['section']) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400); // return error response
            }
            $request->merge(['section_id' => $section_id]);
            $result = $this->quiz->store($request);
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
            $data['quiz'] = $this->quiz->model()->find($id); // data
            if (!$data['quiz']) {
                return $this->responseWithError(___('alert.course_quiz_not_found'), [], 400); // return error response
            }
            $data['url'] = route('course.quiz.update', $id); // url
            $data['title'] = ___('course.Edit quiz'); // title
            @$data['button']   = ___('common.Update');
            $html = view('course::quiz.modal.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
        return view('course::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(QuizRequest $request, $id)
    {
        try {
            $result = $this->quiz->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
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
            $result = $this->quiz->destroy($id);
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
