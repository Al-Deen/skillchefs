<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Instructor\Http\Requests\SkillRequest;
use Modules\Instructor\Interfaces\InstructorInterface;

class SkillController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $instructorRepository;

    public function __construct(InstructorInterface $instructorRepository)
    {

        $this->instructorRepository = $instructorRepository;
    }
    // start addSkill
    public function addSkill(Request $request, $id)
    {
        try {
            $data['url'] = route('admin.instructor.store.skill', $id); // url
            $data['title'] = ___('course.Skills'); // title
            @$data['button'] = ___('instructor.Save & Update'); // button
            $data['instructor'] = $this->instructorRepository->model()->where('user_id', $id)->first();
            $html = view('instructor::modal.skill.edit', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function storeSkill(SkillRequest $request, $id)
    {
        try {
            $result = $this->instructorRepository->storeSkill($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
