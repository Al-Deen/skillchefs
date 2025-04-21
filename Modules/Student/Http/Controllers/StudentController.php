<?php

namespace Modules\Student\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Student\Http\Requests\StudentCreate;
use Modules\Student\Interfaces\StudentInterface;
use Modules\Student\Http\Requests\AdminStudentRequest;

class StudentController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $student;

    public function __construct(StudentInterface $StudentInterface)
    {
        $this->student = $StudentInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index(Request $request)
    {
        try {
            $data['students'] = $this->student->model()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('student.Student Lists'); // title
            return view('student::student.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['title'] = ___('student.Create_Student'); // title
            return view('student::student.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StudentCreate $request)
    {
        try {
            $result = $this->student->create($request);
            if ($result->original['result']) {
                return redirect()->route('admin.student.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * View the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function login($id)
    {
        try {
            $data['student'] = $this->student->model()->where('id', $id)->first(); // data
            if (!$data['student']) {
                return redirect()->back()->with('danger', ___('alert.student_not_found'));
            }
            Auth::loginUsingId($data['student']->user_id);
            return redirect()->route('student.dashboard');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id, $slug)
    {
        try {
            $data['student'] = $this->student->model()->where('id', $id)->first(); // data
            if (!$data['student']) {
                return redirect()->back()->with('danger', ___('alert.student_not_found'));
            }
            $data['url'] = route('admin.student.update', [$data['student']->id, $slug]); // url']
            $data['title'] = ___('student.Update Student'); // title
            return view('student::student.edit', compact('data'));
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
    public function update(AdminStudentRequest $request, $id, $slug)
    {
        try {
            $instructor = $this->student->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->student->update($request, $instructor, $slug);
            if ($result->original['result']) {
                return redirect()->route('admin.student.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
    public function suspend($id)
    {
        try {
            $student = $this->student->model()->where('id', $id)->first(); // data
            if (!$student) {
                return redirect()->back()->with('danger', ___('alert.student_not_found'));
            }
            $result = $this->student->suspend($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
    public function reActivate($id)
    {
        try {
            $student = $this->student->model()->where('id', $id)->first(); // data
            if (!$student) {
                return redirect()->back()->with('danger', ___('alert.student_not_found'));
            }
            $result = $this->student->reActivate($id);
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
