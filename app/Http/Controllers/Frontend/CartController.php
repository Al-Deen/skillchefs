<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\CartInterface;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Order\Interfaces\OrderInterface;

class CartController extends Controller
{
    use ApiReturnFormatTrait;

    // constructor injection

    protected $course;
    protected $cart;
    private $orderRepository;
    private $enrollRepository;

    public function __construct(
        CourseInterface $courseInterface,
        OrderInterface $orderRepository,
        EnrollInterface $enrollRepository,
        CartInterface $cartInterface) {
        $this->course = $courseInterface;
        $this->cart = $cartInterface;
        $this->orderRepository = $orderRepository;
        $this->enrollRepository = $enrollRepository;
    }

    public function index()
    {
        try {
            $data['title'] = ___('frontend.Cart'); // title

            $data['carts'] = session()->get('cart');
            if (!$data['carts']) {
                return redirect()->route('home')->with('danger', ___('alert.Cart_is_empty'));
            }
            return view('frontend.cart.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    // add to cart function start
    public function add(Request $request)
    {
        try {

            $data['course'] = $this->course->model()->findOrFAil(decrypt($request->slug));
            if (!$data['course']) {
                return $this->responseWithError(___('alert.Course_not_found'), [], 400); // return error response
            }

            if (!auth()->check()) {
                return $this->responseWithError(___('alert.Please_login_to_add_course'), [], 400); // return error response
            }

            if (auth()->user()->role_id != 4) {
                return $this->responseWithError(___('alert.You_are_not_a_student'), [], 400); // return error response
            }
            if (@$data['course']->is_free || @$data['course']->price <= 0) {

                try {
                    $cart['carts'] = [
                        [
                            'course_id' => $data['course']->id,
                        ],
                    ];
                    $result = $this->orderRepository->store($cart);
                    if ($result->original['result']) {
                        $this->enrollRepository->store($result->original['data']);
                        $result->original['data'];
                        $result->original['data']->update([
                            'status' => 'paid',
                            'paid_amount' => 0,
                            'due_amount' => 0,
                        ]);
                        $data = [
                            'course' => 'free',
                        ];
                        return $this->responseWithSuccess(___('alert.Course_enrolled_successfully'), $data); // return success response from ApiReturnFormatTrait
                    } else {
                        return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                    }
                } catch (\Throwable $th) {
                    return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                }
            } elseif (module('Subscription') && setting('subscription_setup')) {
                $instructor = $data['course']->user;
                $packageCourseRepository = new \Modules\Subscription\Repositories\PackageCourseRepository(new \Modules\Subscription\Entities\PackageCourse);
                $package_course = $packageCourseRepository->model()->where(['course_id' => $data['course']->id, 'status_id' => 4])->first();
                $data['package_included'] = @$package_course ? 1 : 0;
                if (@$package_course) {
                    try {
                        $cart['carts'] = [
                            [
                                'course_id' => $data['course']->id,
                            ],
                        ];
                        $result = $this->orderRepository->store($cart);
                        if ($result->original['result']) {
                            $this->enrollRepository->store($result->original['data']);
                        }
                        $packagePurchaseRepository = new \Modules\Subscription\Repositories\PackagePurchaseRepository(new \Modules\Subscription\Entities\PackagePurchase, new \Modules\Subscription\Entities\PackageLog);
                        $packagePurchaseRepository->updateCourseEnroll($package_course->package_id);
                        $result->original['data']->update([
                            'status' => 'paid',
                            'paid_amount' => 0,
                            'due_amount' => 0,
                        ]);
                        $data = [
                            'course' => 'free',
                        ];
                        $instructor->update([
                            'balance' => $instructor->balance + ($package_course->package->amount * ($package_course->package->instructor_commission / 100)),
                            'earnings' => $instructor->earnings + ($package_course->package->amount * ($package_course->package->instructor_commission / 100)),
                        ]);
                        return $this->responseWithSuccess(___('alert.Course_enrolled_successfully'), $data); // return success response from ApiReturnFormatTrait
                    } catch (\Throwable $th) {
                        return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
                    }
                }

            }
            // add to cart to session
            $courses = session()->get('cart');
            if ($courses) {
                $courses = array_column($courses, 'course_id');
                if (in_array($data['course']->id, $courses)) {
                    return $this->responseWithError(___('alert.Course_already_added_to_cart'), [], 200); // return error response
                }
            }
            $cartData = [];
            $cartData['course_id'] = $data['course']->id;
            $cartData['course_title'] = $data['course']->title;
            $cartData['slug'] = $data['course']->slug;
            $cartData['author'] = $data['course']->instructor->name;
            $cartData['price'] = $data['course']->price;
            $cartData['rating'] = $data['course']->rating;
            $cartData['total_review'] = $data['course']->total_review;
            $cartData['is_discount'] = $data['course']->is_discount;
            $cartData['discount_type'] = $data['course']->discount_type;
            $cartData['discount'] = $data['course']->discount_price;
            $cartData['discount_price'] = discount_price($data['course']);
            $cartData['length'] = minutes_to_hours($data['course']->course_duration);
            $cartData['lessons'] = $data['course']->lessons->count();
            $cartData['image'] = showImage(@$data['course']->thumbnailImage->paths['300x300']);

            session()->push('cart', $cartData);
            $c_data['total_cart'] = count(session()->get('cart'));
            return $this->responseWithSuccess(___('alert.Course_added_to_cart'), $c_data); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    // add to cart function end

    // start remove from cart
    public function remove(Request $request, $id)
    {
        try {
            $courses = session()->get('cart');
            if ($courses) {
                if (!in_array($id, array_column($courses, 'course_id'))) {
                    return redirect()->back()->with('danger', ___('alert.Course_not_found'));
                }
            }
            $cartData = [];
            foreach ($courses as $key => $course) {
                if ($course['course_id'] == $id) {
                    unset($courses[$key]);
                }
            }
            session()->put('cart', $courses);
            return redirect()->route('cart.index')->with('success', ___('alert.Course_removed_from_cart'));
        } catch (\Throwable $th) {
            return redirect()->route('cart.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
