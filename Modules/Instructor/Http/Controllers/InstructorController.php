<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Instructor\Http\Requests\InstructorCreate;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Instructor\Http\Requests\AdminInstructorRequest;

class InstructorController extends Controller
{

    use ApiReturnFormatTrait;

    // constructor injection
    protected $instructor;

    public function __construct(InstructorInterface $InstructorInterface)
    {
        $this->instructor = $InstructorInterface;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function requests(Request $request)
    {
        try {
            $data['instructors'] = $this->instructor->model()->pending()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('instructor.Instructor Request Lists'); // title
            return view('instructor::instructor.request', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function suspends(Request $request)
    {
        try {
            $data['instructors'] = $this->instructor->model()->suspended()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('instructor.Instructor Suspended Lists'); // title
            return view('instructor::instructor.suspend', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function index(Request $request)
    {
        try {
            $data['instructors'] = $this->instructor->model()->active()->filter($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('instructor.Instructor Lists'); // title
            return view('instructor::instructor.index', compact('data')); // view
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
            $data['title'] = ___('instructor.Create Instructor'); // title
            return view('instructor::instructor.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(InstructorCreate $request)
    {
        try {
            $result = $this->instructor->create($request);
            if ($result->original['result']) {
                return redirect()->route('admin.instructor.index')->with('success', $result->original['message']);
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
            $data['instructor'] = $this->instructor->model()->where('id', $id)->first(); // data
            if (!$data['instructor']) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            Auth::loginUsingId($data['instructor']->user_id);
            return redirect()->route('instructor.dashboard');
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
            $data['instructor'] = $this->instructor->model()->where('id', $id)->first(); // data
            if (!$data['instructor']) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $data['url'] = route('admin.instructor.update', [$data['instructor']->id, $slug]); // url']
            $data['title'] = ___('instructor.Update Instructor'); // title
            return view('instructor::instructor.edit', compact('data'));
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
    public function update(AdminInstructorRequest $request, $id, $slug)
    {
        try {
            $instructor = $this->instructor->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->instructor->update($request, $instructor, $slug);
            if ($result->original['result']) {
                return redirect()->route('admin.instructor.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
    public function approve($id)
    {
        try {
            $instructor = $this->instructor->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->instructor->approve($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
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
            $instructor = $this->instructor->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->instructor->suspend($id);
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
            $instructor = $this->instructor->model()->where('id', $id)->first(); // data
            if (!$instructor) {
                return redirect()->back()->with('danger', ___('alert.instructor_not_found'));
            }
            $result = $this->instructor->reActivate($id);
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
