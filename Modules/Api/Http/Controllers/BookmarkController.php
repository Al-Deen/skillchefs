<?php

namespace Modules\Api\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Entities\Bookmark;
use Illuminate\Contracts\Support\Renderable;
use Modules\Api\Collections\CourseCollection;
use Modules\Api\Interfaces\BookmarkInterface;
use Modules\Api\Collections\BookmarkCollection;
use Modules\Api\Collections\AssignmentCollection;

class BookmarkController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $bookmark;


    public function __construct(BookmarkInterface $bookmarkInterface)
    {
        $this->bookmark                = $bookmarkInterface;
    }


    public function bookmark(Request $request){
        try {
            $bookmark    = $this->bookmark->model()->where('user_id', Auth::id())
            ->with('course:id,title,price,discount_price,total_review,rating,total_sales,thumbnail')
            ->search($request)
            ->latest()
            ->get();

            if($bookmark->isNotEmpty()){
                $data['bookmarks'] = new BookmarkCollection($bookmark);
                return $this->responseWithSuccess(___('student.data found'), $data);
            }else{
                return $this->responseWithError(___('alert.no data found'), [], 400); // return error response
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response

        }
    }

    public function bookmarkUpdate(Request $request)
    {
        try {
            $result = $this->bookmark->update($request->course_id);

            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']);
            } else {
                return $this->responseWithError($result->original['message']);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

}
