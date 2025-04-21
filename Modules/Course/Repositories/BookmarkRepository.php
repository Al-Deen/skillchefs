<?php

namespace Modules\Course\Repositories;

use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use App\Traits\ApiReturnFormatTrait;
use Modules\Course\Entities\Bookmark;
use Modules\Course\Interfaces\BookmarkInterface;

class BookmarkRepository implements BookmarkInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $courseModel;

    public function __construct(Bookmark $bookModal,Course $courseModel)
    {
        $this->model = $bookModal;
        $this->courseModel = $courseModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($course_id)
    {

        DB::beginTransaction(); // start database transaction
        try {
            $course = $this->courseModel->where('id', decryptFunction($course_id))->first();
            if (!$course) {
                return $this->responseWithError(___('alert.course_not_found'), [], 400);
            }
            $bookmark                     = new $this->model;
            $bookmark->course_id          = decryptFunction($course_id);
            $bookmark->user_id            = auth()->user()->id;
            $bookmark->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Bookmark added successfully.'),$bookmark); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function destroy($course_id)
    {
        try {
            $bookmark = $this->model->where('course_id', $course_id)->where('user_id', auth()->user()->id)->first();
            if (!$bookmark) {
                return $this->responseWithError(___('alert.Bookmark not found'), [], 400);
            }
            $bookmark->delete();
            return $this->responseWithSuccess(___('alert.Bookmark removed successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
