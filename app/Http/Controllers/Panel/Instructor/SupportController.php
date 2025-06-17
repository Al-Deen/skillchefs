<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Models\LiveSupport;
use App\Models\Support;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Course\Http\Requests\Instructor\NoticeBoardRequest;
use App\Traits\ApiReturnFormatTrait;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Interfaces\NoticeboardInterface;

class SupportController extends Controller
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
    public function create($course_id)
    {

        try {
            $data['course'] = $this->course->model()->where('id', $course_id)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['course']) {
                return $this->responseWithError(___('alert.course_not_found'), [], 400); // return error response
            }
            $data['url'] = route('instructor.support.store', $course_id); // url
            $data['title'] = ___('course.Create Support'); // title
             return view('panel.instructor.course.support.create', compact('data'));
            } catch (\Throwable $th) {
        return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function store(Request $request, $course_id)
    {

        try {
            $course= $this->course->model()->where('id', $course_id)->where('created_by', auth()->user()->id)->first(); // data
            $data = $request->all();
            $data['course_id'] = $course->id;
            $data['status'] = 1;
            $data['created_by'] = auth()->user()->id;
            Support::create($data);
            return redirect()->route('instructor.course.support',$course->slug)->with('success', 'Support Link Created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function edit($id)
    {
        try {
            $data['support'] = Support::where('id', $id)->where('created_by', auth()->user()->id)->first(); // data
            $data['title'] = 'Edit Support';
            return view('panel.instructor.course.support.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $support = Support::where('id', $id)->where('created_by', auth()->user()->id)->first();
            $data = $request->all();
            $data['updated_by'] = auth()->user()->id;
            $support->update($data);
            return redirect()->route('instructor.course.support',$support->course->slug)->with('success', 'Support Link Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function destroy($id)
    {
        try {
            $support =Support::find($id);
            $support->delete();
            return redirect()->back()->with('success', 'Support Link Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function studentList($support_id)
    {
        $data['title'] ='Support Student List';
        $data['supportStudents'] = LiveSupport::where('support_id',$support_id)->paginate(10);
        return view('panel.instructor.course.support.student-list', compact('data'));

    }

//    public function studentterminate($id)
//    {
//        try {
//            $liveSupport =LiveSupport::find($id);
//            $liveSupport->status = 2;
//            $liveSupport->save();
//            return redirect()->back()->with('success', 'Support Student Terminated !');
//        } catch (\Throwable $th) {
//            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
//        }
//    }

    public function studentterminate($id)
    {
        try {
            $activeLiveSupport = LiveSupport::findOrFail($id);
            $support = Support::findOrFail($activeLiveSupport->support_id);
            $interval = $support->interval;

            // Step 1: Current time, seconds always set to 00
            $currentTime = Carbon::now('Asia/Dhaka')->second(0);

            // Step 2: Update the terminated student's status to 2
            $activeLiveSupport->status = 2;
            $activeLiveSupport->save();

            // Step 3: Get next two pending students (status = 0)
            $nextLiveSupports = LiveSupport::where('support_id', $support->id)
                ->where('status', 0)
                ->orderBy('id','asc')
                ->get();

            foreach ($nextLiveSupports as $nextSupport) {
                $nextSupport->start_time = $currentTime->copy()->format('Y-m-d H:i:00');
                $currentTime->addMinutes($interval);
                $nextSupport->end_time = $currentTime->copy()->format('Y-m-d H:i:00');
                $nextSupport->save();
            }

            return redirect()->back()->with('success', 'Support Student Terminated!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
