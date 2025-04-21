<?php

namespace App\Http\Controllers\Panel\Student;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Course\Interfaces\ReviewInterface;
use Modules\Course\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{

    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $enrollRepository;
    protected $reviewRepository;
    protected $template = 'panel.student';

    public function __construct(EnrollInterface $enrollRepository, ReviewInterface $reviewRepository)
    {
        $this->enrollRepository = $enrollRepository;
        $this->reviewRepository   = $reviewRepository;
    }
    public function reviewCreate($enroll_id)
    {
        try {
            $enroll_id = decryptFunction($enroll_id);
            $enroll = $this->enrollRepository->model()->where('user_id', Auth::id())->where('id', $enroll_id)->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.Lesson not found'), [], 400); // return error response
            }
            $data['url'] = route('student.review.store', encryptFunction($enroll_id)); // url
            $data['title'] = ___('course.Create Review'); // title
            @$data['button']   = ___('common.Save');
            $html = view('panel.student.course.modal.review.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function reviewStore(ReviewRequest $request, $enroll_id)
    {
        try {
            $enroll_id = decryptFunction($enroll_id);
            $request->merge(['enroll_id' => $enroll_id]);
            $result = $this->reviewRepository->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'],  $result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
