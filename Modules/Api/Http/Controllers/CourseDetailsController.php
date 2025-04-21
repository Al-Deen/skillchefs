<?php

namespace Modules\Api\Http\Controllers;

use App\Models\User;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Order\Interfaces\EnrollInterface;

class CourseDetailsController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $enrollRepository;

    public function __construct(EnrollInterface $enrollRepository) {
        $this->enrollRepository = $enrollRepository;
    }
    public function courseLearn($course_id, $user_id, $lesson_id){
            try {

                Auth::login(User::find($user_id));

                $lesson_id = decryptFunction($lesson_id);
                $data['title']      = ___('student.Student Course Learn'); // title
                $data['enroll']     = $this->enrollRepository->model()->where('user_id', auth()->id())->whereHas('course', function ($q) use ($course_id) {
                    $q->where('id', $course_id);
                })->with('course:id,title,course_duration,created_by,requirements,outcomes,description', 'lessons')->first();

                $data['lesson']     = $data['enroll']->lessons->find($lesson_id);
                if (!$data['enroll'] || !$data['lesson']) {
                    return redirect()->back()->with('danger', ___('alert.Lesson not found'));
                }
                $this->enrollRepository->visited($data['enroll']);
                $data['lesson_id'] = $lesson_id;

                return view('api::course_details', compact('data'));
            } catch (\Throwable $th) {
                return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
            }
    }
    public function course($course_id, $user_id){
            try {
                Auth::login(User::find($user_id));
                $data['title']      = ___('student.Student Course Learn'); // title
                $data['enroll']     = $this->enrollRepository->model()->where('user_id', auth()->id())->whereHas('course', function ($q) use ($course_id) {
                    $q->where('id', $course_id);
                })->with('course:id,title,course_duration,created_by,requirements,outcomes,description,thumbnail', 'lessons')->first();
                $this->enrollRepository->visited($data['enroll']);
                return view('api::course_details', compact('data'));
            } catch (\Throwable $th) {
                dd($th);
                return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
            }
    }
}
