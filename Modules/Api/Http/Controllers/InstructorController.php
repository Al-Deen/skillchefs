<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Interfaces\UserInterface;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Api\Transformers\InstructorResource;
use Modules\Api\Collections\InstructorCollection;
use Modules\Instructor\Interfaces\InstructorInterface;

class InstructorController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $instructor;
    protected $user;


    public function __construct(
        InstructorInterface $instructor,
        UserInterface $user
    ) {
        $this->instructor   = $instructor;
        $this->user         = $user;
    }


    public function index(Request $request)
    {
        try {
            $search = $request->search;

            $instructors = $this->instructor->model()->with('user')->whereHas('user', function ($query) {
                $query->where('status_id', 4);
            })->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%');
                });
            })->paginate(6);

            $data['instructors'] = new InstructorCollection($instructors);

            if ($data['instructors']->isEmpty()) {
                return $this->responseWithError(___('course.No data found'));
            }else{
                return $this->responseWithSuccess(___('course.data found'), $data);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }


    public function details(Request $request)
    {
        try {
            $instructor = $this->instructor->model()->with('user')->where('id', $request->id)->first();

            if(!empty($instructor)){
                $data['instructor'] = new InstructorResource($instructor);

                if ($data['instructor']) {
                    return $this->responseWithSuccess(___('course.data found'), $data);
                }
            }else{
                return $this->responseWithError(___('course.No data found'));
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
