<?php

namespace Modules\Course\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Modules\Order\Entities\Note;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Enroll;
use Illuminate\Support\Facades\Log;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Review;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Interfaces\ReviewInterface;

class ReviewRepository implements ReviewInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;
    private $courseModel;
    protected $userModel;
    protected $enrollModel;

    public function __construct(Review $reviewModel, Course $courseModel, User $userModel, Enroll $enrollModel)
    {
        $this->model = $reviewModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->enrollModel = $enrollModel;
    }

    public function model()
    {
        return $this->model;
    }


    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $enroll_id = ($request->enroll_id);
            $enroll = $this->enrollModel->where('user_id', Auth::id())->where('id', $enroll_id)->first();
            if (!$enroll) {
                return $this->responseWithError(___('alert.Course not found'), [], 400); // return error response
            }

            $review = new $this->model;
            $review->user_id = Auth::id();
            $review->course_id = $enroll->course_id;
            $review->rating = $request->rating;
            $review->comment = $request->review;
            $review->save();
            $enroll->course->update([
                'rating' => $enroll->course->reviews()->avg('rating'),
                'total_review' => $enroll->course->reviews()->count(),
            ]);
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Review created successfully.'), $review); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $note = $this->model()->where('user_id', Auth::id())->find($id);
            if (!$note) {
                return $this->responseWithError(___('alert.Note not found'), [], 400); // return error response
            }
            $note->description = $request->note;
            $note->save();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note updated successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction(); // start database transaction
        try {
            $enroll = $this->model()->find($id);
            if (!$enroll) {
                return $this->responseWithError(___('alert.Note not found'), [], 400); // return error response
            }
            $enroll->delete();
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Note deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
