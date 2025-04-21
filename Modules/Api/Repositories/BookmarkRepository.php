<?php

namespace Modules\Api\Repositories;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Hash;
use Modules\Course\Entities\Bookmark;
use Modules\Student\Entities\Student;
use Modules\Api\Interfaces\BookmarkInterface;


class BookmarkRepository implements BookmarkInterface
{

    use ApiReturnFormatTrait, FileUploadTrait;

    protected $model;
    protected $studentModel;

    public function __construct(User $userModel, Bookmark $model) {
        $this->userModel = $userModel;
        $this->model = $model;
    }

    public function model(){
        return $this->model;
    }

    public function update($id){
        try{
            $bookmark = $this->model->where('user_id', auth()->id())->where('course_id', $id)->first();
            if(empty($bookmark)){
                $newBookmark = new $this->model();
                $newBookmark->course_id = $id;
                $newBookmark->user_id = auth()->id();
                $newBookmark->save();
                return $this->responseWithSuccess(___('alert.Bookmark Added successfully.'));
            }else{
                $bookmark->delete();
                return $this->responseWithSuccess(___('alert.Bookmark Removed successfully.'));
            }
        }catch(\Throwable $th){
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400);
        }
    }

}
