<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Blog\Interfaces\BlogInterface;
use Modules\Brand\Interfaces\BrandInterface;
use Modules\Certificate\Interfaces\CertificateGenerateInterface;
use Modules\CMS\Interfaces\FeaturedCourseInterface;
use Modules\CMS\Interfaces\HomeSectionInterface;
use Modules\CMS\Interfaces\TestimonialInterface;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Slider\Interfaces\SliderInterface;

class HomeController extends Controller
{
    use ApiReturnFormatTrait;

    protected $slider;
    protected $blog;
    protected $courseCategory;
    protected $brand;
    protected $homeSection;
    protected $featuredCourse;
    protected $testimonial;
    protected $certificateRepository;
    protected $course;

    // constructor injection
    public function __construct(
        SliderInterface $slider,
        BlogInterface $blog,
        CourseCategoryInterface $courseCategory,
        BrandInterface $brand,
        HomeSectionInterface $homeSectionInterface,
        FeaturedCourseInterface $featuredCourseInterface,
        TestimonialInterface $testimonialInterface,
        CertificateGenerateInterface $certificateGenerateInterface,
        CourseInterface $courseInterface,
    ) {
        $this->slider = $slider;
        $this->blog = $blog;
        $this->courseCategory = $courseCategory;
        $this->brand = $brand;
        $this->homeSection = $homeSectionInterface;
        $this->featuredCourse = $featuredCourseInterface;
        $this->testimonial = $testimonialInterface;
        $this->course = $courseInterface;
        $this->certificateRepository = $certificateGenerateInterface;
    }

    public function index(Request $request)
    {

        try {
            $data['title'] = ___('frontend.Home'); // title

            if (Cache::has('sections')) {
                $sections = Cache::get('sections');
            } else {
                $sections = $this->homeSection->model()->where('type', 'web')->where('status_id',1)->orderBy('order', 'ASC')->get(); // get all home section
                Cache::put('sections', $sections);
            }
            $data['section'] = $sections;

            return view('frontend.home', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    // ajax slider data start
    public function homeSliders()
    {

        try {
            if (Cache::has('sliders')) {
                $sliders = Cache::get('sliders');
            } else {
                $sliders = $this->slider->getAllSlider();
                Cache::put('sliders', $sliders);
            }
            $data['sliders'] = $sliders;
            if ($data['sliders']) {
                $view = view('frontend.ajax.home.ot_banner_area', compact('data'))->render();
                $response['content'] = $view;
                $response['message'] = ___('frontend.Home Slider Found');
                return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
            }

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));

        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax slider data end

    // ajax featured courses data start
    public function featuredCourses()
    {
        try {
            if (Cache::has('featured_courses')) {
                $featuredCourses = Cache::get('featured_courses');
            } else {
                $featuredCourses = $this->featuredCourse->model()->active()->with('course')->orderBy('id', 'ASC')->limit(8)->get();
                Cache::put('featured_courses', $featuredCourses);
            }
            $data['courses'] = $featuredCourses;
            $data['title'] = ___('frontend.Featured Courses');
            $data['url'] = route('courses') . '?type=featured';
            $view = view('frontend.ajax.home.ot_featured_courses_area', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Featured Courses');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax featured courses data end

    // ajax popular courses data start
    public function popularCategory()
    {

        try {
            $data['popularCategories'] = $this->courseCategory->popularCategory();
            $data['section_title'] = ___('frontend.Popular category');
            if ($data['popularCategories']) {
                $view = view('frontend.ajax.home.ot_categories_area', compact('data'))->render();
                $response['content'] = $view;
                $response['message'] = ___('frontend.Popular category found');
                return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
            }
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax popular courses data end

    // ajax latest courses data start
    public function latestCourses()
    {
        try {

                $latest = $this->course->model()->active()->visible()->orderBy('id', 'DESC')->limit(8)->get();

            $data['courses'] = $latest;
            $data['title'] = ___('frontend.Latest Courses');
            $data['url'] = route('courses') . '?sort=latest';
            $view = view('frontend.ajax.home.ot_courses_area', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Latest Courses');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax latest courses data end

    // ajax best rated courses data start
    public function bestRatedCourses()
    {
        try {
            // if (Cache::has('best_rated_courses')) {
            //     $courses = Cache::get('best_rated_courses');
            // } else {
                $courses = $this->course->model()->active()->visible()->orderBy('rating', 'DESC')->limit(8)->get();
            //     Cache::put('best_rated_courses', $courses);
            // }
            $data['courses'] = $courses;
            $data['title'] = ___('frontend.Best Rated Courses');
            $data['url'] = route('courses') . '?sort=best_rated';
            $view = view('frontend.ajax.home.ot_courses_area', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Best Rated Courses');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax best rated courses data end
    // ajax best selling courses data start
    public function mostPopularCourses()
    {
        try {

                $courses = $this->course->model()->active()->visible()->orderBy('total_sales', 'DESC')->limit(8)->get();

            $data['courses'] = $courses;
            $data['title'] = ___('frontend.Most Popular Courses');
            $data['url'] = route('courses') . '?sort=popular';
            $view = view('frontend.ajax.home.ot_courses_area', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Most Popular Courses');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax best selling courses data end
    // ajax discount courses data start
    public function discountCourses()
    {
        try {
            // if (Cache::has('discount_courses')) {
            //     $courses = Cache::get('discount_courses');
            // } else {
                $courses = $this->course->model()->active()->visible()->orderBy('discount_price', 'DESC')->limit(8)->get();
            //     Cache::put('discount_courses', $courses);
            // }
            $data['courses'] = $courses;
            $data['title'] = ___('frontend.Discount Courses');
            $data['url'] = route('courses') . '?type=discount';
            $view = view('frontend.ajax.home.ot_courses_area', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Discount Courses');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax discount courses data end

    // ajax testimonials data start
    public function testimonials()
    {
        try {
            if (Cache::has('testimonials')) {
                $testimonials = Cache::get('testimonials');
            } else {
                $testimonials = $this->testimonial->model()->active()->orderBy('id', 'DESC')->limit(8)->get();
                Cache::put('testimonials', $testimonials);
            }
            $data['testimonials'] = $testimonials;
            $data['title'] = ___('frontend.Testimonials');
            $view = view('frontend.ajax.home.ot_testimonials_area', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Testimonials');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    // ajax menu categories start

    public function menuCategories()
    {

        try {
            if (Cache::has('menu_categories')) {
                $data['categories'] = Cache::get('menu_categories');
            } else {
                $data['categories'] = $this->courseCategory->filter(['parent_id' => null])->active()->orderBy('id', 'DESC')->get();
                Cache::put('menu_categories', $data['categories']);
            }
            $view = view('frontend.ajax.header.categories', compact('data'))->render();
            $response['content'] = $view;
            $response['message'] = ___('frontend.Menu Categories');
            return $this->responseWithSuccess(___('alert.Data found.'), $response); // return success response from ApiReturnFormatTrait
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }
    // ajax menu categories end

    public function blogs()
    {

        try {

            $data['blogs'] = $this->blog->homeBlog();
            $data['section_title'] = ___('frontend.Our Recent Blogs');

            if ($data['blogs']) {
                $view = view('frontend.ajax.home.ot_blog_area', compact('data'))->render();
                $data['content'] = $view;
                $data['message'] = ___('frontend.Blogs Found');
                return $this->responseWithSuccess(___('alert.Data found.'), $data); // return success response from ApiReturnFormatTrait
            }

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function brands()
    {

        try {

            $data['brands'] = $this->brand->getAllBrands(); // This function comes from BlogRepository
            $data['section_title'] = ___('frontend.Trusted By Thousands');

            if ($data['brands']) {
                $view = view('frontend.ajax.home.ot_brands', compact('data'))->render();
                $data['content'] = $view;
                $data['message'] = ___('frontend.Brands Found');
                return $this->responseWithSuccess(___('alert.Data found.'), $data); // return success response from ApiReturnFormatTrait
            }

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function certificateTrack(Request $request)
    {
        try {
            $data['title'] = ___('frontend.Track_Your_Certificate'); // title
            return view('frontend.certificate', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function certificateView(Request $request)
    {

        try {
            $certificate = $this->certificateRepository->model()->where('certificate_id', $request->certificate_id)->first();
            if ($certificate) {
                $data['certificate'] = $certificate;
                $data['title'] = ___('frontend.Certificate_Tracked'); // title
                return view('frontend.certificate', compact('data'));
            }
            return redirect()->route('front.certificate')->with('danger', ___('alert.certificate_not_valid'));

        } catch (\Throwable $th) {
            return redirect()->route('front.certificate')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
}
