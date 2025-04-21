<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Organization\Interfaces\InstructorCommissionInterface;

class CourseDetailsController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection
    protected $course;
    protected $instructorCommissionInterface;

    public function __construct(CourseInterface $courseInterface, InstructorCommissionInterface $instructorCommissionInterface)
    {
        $this->course = $courseInterface;
        $this->instructorCommissionInterface = $instructorCommissionInterface;
    }

    public function index($slug)
    {
        try {
            $data['title'] = ___('frontend.Course Details'); // title
            $data['course'] = $this->course->model()->slug($slug)->first();

            if($data['course']->user->role_id == Role::INSTRUCTOR){
                $data['user_type'] = ___('frontend.Instructor');
                $data['profile'] = view('frontend.partials.course.instructor_profile', compact('data'))->render();

            } else{
                $data['user_type'] = ___('frontend.Organization');
                $data['instructors'] = $this->instructorCommissionInterface->model()->where('course_id', $data['course']->id)->get();
                $data['profile'] = view('organization::panel.organization.frontend.partials.organization_profile', compact('data'))->render();
            }
            $data['review'] = view('frontend.partials.course.reviews', compact('data'))->render();
            $data['curriculum'] = view('frontend.partials.course.curriculum', ['sections' => $data['course']->sections])->render();

            if ($data['course']) {
                // package course
                if(module('Subscription') && setting('subscription_setup')){
                    $packageCourseRepository = new \Modules\Subscription\Repositories\PackageCourseRepository(new \Modules\Subscription\Entities\PackageCourse);
                    $package_course = $packageCourseRepository->model()->where(['course_id' => $data['course']->id, 'status_id' => 4])->first();
                    $data['package_included'] = @$package_course ? 1 : 0;
                }
                // package course end
                return view('frontend.course.course_details', compact('data'));
            } else {
                return redirect('/')->with('danger', ___('alert.Course_not_found'));
            }
        } catch (\Throwable $th) {
            dd($th);
            return redirect('/')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
}
