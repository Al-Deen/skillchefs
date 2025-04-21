<?php

namespace Modules\Organization\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Organization\Interfaces\InstructorCommissionInterface;

class InstructorController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $instructorCommissionInterface;

    public function __construct(InstructorCommissionInterface $instructorCommissionInterface)
    {
        $this->instructorCommissionInterface = $instructorCommissionInterface;
    }

    public function index(Request $request)
    {
        try {
            $data['title'] = ___('instructor.Organization Courses'); // title
            $data['instructor_commission'] = $this->instructorCommissionInterface->model()->with('course')
                ->where('user_id', auth()->user()->id)
                ->search($request)
                ->paginate(10);
            return view('organization::panel.instructor.course.my_courses', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


}
