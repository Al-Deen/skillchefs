<?php

namespace App\Http\Controllers\Api\V1\Student;


use Illuminate\Http\Request;
use App\Interfaces\CartInterface;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Course\Interfaces\CourseInterface;
use App\Http\Requests\api\cart\CartStoreRequest;
use App\Http\Requests\api\cart\CartDeleteRequest;

class CartController extends Controller
{
    use ApiReturnFormatTrait;



    // constructor injection
    protected $cart;
    public function __construct(CartInterface $cartInterface)
    {
        $this->cart   = $cartInterface;
    }



    public function index()
    {

        try {
            $data['carts'] = $this->cart->model()
                ->with('course:id,title,short_description,price,discount_price,course_category_id,thumbnail', 'course.thumbnailImage', 'course.category:id,title')
                ->where('user_id', auth()->id())->get();

            if ($data['carts']) {
                return $this->responseWithSuccess(___('course.data found'), $data['carts']);
            }
            return $this->responseWithError(___('alert.No data found')); // return error response

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function store(CartStoreRequest $request)
    {

        try {
            $result = $this->cart->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']);
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    public function destroy(CartDeleteRequest $request)
    {
        try {
            $result = $this->cart->destroy($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['result']);
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
