<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\User;
use App\Models\Search;
use App\Models\Language;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Schema;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Accounts\Interfaces\IncomeInterface;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Accounts\Interfaces\ExpenseInterface;
use Modules\Instructor\Interfaces\PayoutInterface;
use Modules\CMS\Interfaces\FeaturedCourseInterface;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Certificate\Interfaces\CertificateGenerateInterface;

class DashboardController extends Controller
{
    use ApiReturnFormatTrait;

    private $user;
    private $student;
    private $instructor;
    private $enroll;
    private $course;
    private $featuredCourse;
    private $certificateGenerate;
    private $income;
    private $expense;
    private $payout;
    private $orderInterface;

    public function __construct(
        UserInterface $userInterface,
        StudentInterface $student,
        InstructorInterface $instructor,
        EnrollInterface $enroll,
        CourseInterface $course,
        FeaturedCourseInterface $featuredCourse,
        CertificateGenerateInterface $certificateGenerate,
        IncomeInterface $income,
        ExpenseInterface $expense,
        PayoutInterface $payout,
        OrderInterface $orderInterface
    ) {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->user = $userInterface;
        $this->student = $student;
        $this->instructor = $instructor;
        $this->enroll = $enroll;
        $this->course = $course;
        $this->featuredCourse = $featuredCourse;
        $this->certificateGenerate = $certificateGenerate;
        $this->income = $income;
        $this->expense = $expense;
        $this->payout = $payout;
        $this->orderInterface = $orderInterface;

    }

    public function index(Request $request)
    {
        try {

            $data['student'] = $this->student->model()->count();
            $data['instructor'] = $this->instructor->model()->count();
            $data['enroll'] = $this->enroll->model()->count();
            $courses = $this->course->model();
            $data['course'] = $courses->clone()->count();
            $data['active_course'] = $courses->clone()->where('status_id', 1)->count();
            $data['pending_course'] = $courses->clone()->where('status_id', 4)->count();
            $data['featured_course'] = $this->featuredCourse->model()->count();
            $data['discount_course'] = $courses->clone()->where('is_discount', 11)->count();
            $data['certificate_generate'] = $this->certificateGenerate->model()->count();
            $data['pending_payout'] = $this->payout->model()->where('status_id', 4)->count();
            $data['income'] = $this->income->model()->sum('amount');
            $data['expense'] = $this->expense->model()->sum('amount');
            $data['top_courses'] = $courses->clone()->orderBy('total_sales', 'desc')->limit(5)->get();
            $data['top_students'] = $this->student->model()->orderBy('points', 'desc')->limit(5)->get();
            $data['top_instructors'] = $this->instructor->model()->withCount('courses')->orderBy('courses_count', 'desc')->limit(5)->get();
            return view('backend.dashboard', compact('data'));

        } catch (\Throwable $th) {
            return redirect('/')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function revenue(Request $request)
    {
        if ($request->ajax()) {
           return $result = $this->income->revenue();
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } else {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function sales(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->orderInterface->monthlySales($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } else {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function schoolDashboard()
    {
        /*
        Summery
         */

        //Users
        $users['total'] = User::count();
        $users['active'] = User::where('status', 1)->count();
        $users['inactive'] = User::where('status', 4)->count();

        //Roles
        $roles['total'] = Role::count();
        $roles['active'] = Role::where('status', 1)->count();
        $roles['inactive'] = Role::where('status', 4)->count();

        //Languages
        $languages['total'] = Language::count();
        $languages['active'] = Language::count(); //lanuage status are not assigned
        $languages['inactive'] = 0; //lanuage status are not assigned

        //Languages
        $permissions['total'] = Permission::count();
        $permissions['active'] = Permission::count(); //lanuage status are not assigned
        $permissions['inactive'] = 0; //lanuage status are not assigned

        //users
        $user = $this->user->getAll();

        return view('backend.school_dashboard', [
            "users" => $users,
            "roles" => $roles,
            "languages" => $languages,
            "permissions" => $permissions,
            "user" => $user,
        ]);
    }
    public function lmsDashboard()
    {
        /*
        Summery
         */

        //Users
        $users['total'] = User::count();
        $users['active'] = User::where('status', 1)->count();
        $users['inactive'] = User::where('status', 4)->count();

        //Roles
        $roles['total'] = Role::count();
        $roles['active'] = Role::where('status', 1)->count();
        $roles['inactive'] = Role::where('status', 4)->count();

        //Languages
        $languages['total'] = Language::count();
        $languages['active'] = Language::count(); //lanuage status are not assigned
        $languages['inactive'] = 0; //lanuage status are not assigned

        //Languages
        $permissions['total'] = Permission::count();
        $permissions['active'] = Permission::count(); //lanuage status are not assigned
        $permissions['inactive'] = 0; //lanuage status are not assigned

        //users
        $user = $this->user->getAll();

        return view('backend.lms_dashboard', [
            "users" => $users,
            "roles" => $roles,
            "languages" => $languages,
            "permissions" => $permissions,
            "user" => $user,
        ]);
    }

    public function searchMenuData(Request $request)
    {
        $targets = Search::where('url', 'LIKE', "%{$request->searchData}%")->get();
        $view = View('backend.menu-autocomplete', compact('targets'))->render();
        return response()->json(['data' => $view]);
    }
}
