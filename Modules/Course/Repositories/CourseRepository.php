<?php

namespace Modules\Course\Repositories;

use App\Models\User;
use App\Models\Status;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Slider\Entities\Slider;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\CMS\Entities\FeaturedCourse;
use Modules\Course\Entities\CourseCategory;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Course\Transformers\CourseResource;
use Modules\Course\Transformers\featuredCourseResource;

class CourseRepository implements CourseInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    protected $sliderModel;
    protected $courseCategoryModel;
    protected $featuredCourseModel;
    protected $userModel;
    protected $statusModel;
    protected $setting;

    public function __construct(
        Course $courseModel,
        Slider $sliderModel,
        CourseCategory $courseCategoryModel,
        FeaturedCourse $featuredCourseModel,
        User $userModel,
        Status $statusModel,
        Setting $setting)
    {
        $this->model = $courseModel;
        $this->sliderModel = $sliderModel;
        $this->courseCategoryModel = $courseCategoryModel;
        $this->featuredCourseModel = $featuredCourseModel;
        $this->userModel = $userModel;
        $this->statusModel = $statusModel;
        $this->setting = $setting;
    }

    public function all()
    {
        try {
            return $this->model->get();
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Title'),
            ___('common.Category'),
            ___('common.Instructor'),
            ___('course.Content'),
            ___('course.Enrollment'),
            ___('common.price'),
            ___('label.Course Type'),
            ___('ui_element.status'),
            ___('course.Visibility'),
            ___('ui_element.action'),
        ];
    }

    public function model()
    {

        return $this->model;
    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function params($params = null)
    {
        $category = $params->category ?? null;
        $instructor = $params->instructor_id ?? null;
        $search = $params->search ?? null;
        return [
            'category' => $this->courseCategoryModel->active()->where('id', $category)->first()->title ?? null,
            'instructor' => $this->userModel->where('id', $instructor)->first()->name ?? null,
            'search' => $search,
        ];
    }

    public function courseDiscount($request)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $course = $this->model->find($request->course_id);
            if (!$course) {
                return $this->responseWithError(___('alert.Course_not_found.'));
            }
            if ($request->discount_type == 1 && $request->discount_price > $course->price) {
                return $this->responseWithError(___('alert.Discount_price_must_be_less_than_course_price.'));
            }
            $course->is_discount = 11;
            $course->discount_price = $request->discount_price;
            $course->discount_type = $request->discount_type;
            $course->save();
            return $this->responseWithSuccess(___('alert.Course_discount_updated_successfully.'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function courseDiscountDestroy($id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $course = $this->model->find($id);
            if (!$course) {
                return $this->responseWithError(___('alert.Course_not_found.'));
            }
            $course->is_discount = 10;
            $course->discount_price = 0;
            $course->discount_type = null;
            $course->save();
            return $this->responseWithSuccess(___('alert.Course_discount_removed_successfully.'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function store($request)
    {
        if (env('APP_DEMO')) {
            return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
        }
        DB::beginTransaction(); // start database transaction
        try {
            $courseModel = new $this->model; // create new object of model for store data in database table
            $courseModel->title = $request->title;
            $courseModel->slug = Str::slug($request->title) . '-' . Str::random(8);
            $courseModel->course_type = $request->course_type;
            $courseModel->level_id = $request->course_level;
            $courseModel->short_description = $request->short_description;
            $courseModel->description = $request->description;
            $courseModel->course_category_id = $request->category;
            $courseModel->visibility_id = $request->visibility_id;
            $courseModel->status_id = $request->status_id ?? 1;
            $courseModel->language = $request->language_id;
            $courseModel->requirements = $request->requirements;
            $courseModel->outcomes = $request->outcomes;
            $courseModel->is_free = $request->is_free ?? 0;
            $courseModel->price = @$request->price ?? 0;
            if (@$request->is_discount) {
                $courseModel->is_discount = $request->is_discount ?? 10;
                $courseModel->discount_price = $request->discount_price ?? 10;
                $courseModel->discount_type = $request->discount_type;
            }
            $courseModel->course_overview_type = $request->course_preview ?? null;
            $courseModel->video_url = $request->video_url ?? null;
            $courseModel->meta_title = $request->meta_title;
            $courseModel->meta_keywords = $request->meta_keyword;
            $courseModel->meta_author = auth()->user()->name;
            $courseModel->meta_description = $request->meta_description;
            $courseModel->instructor_id = $request->instructor;
            $courseModel->partner_instructors = @$request->partner_instructor;
            $courseModel->created_by = $request->instructor;
            $courseModel->updated_by = auth()->user()->id;
            // thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $upload = $this->uploadFile($request->thumbnail, 'course/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $courseModel->thumbnail = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            // meta image upload
            if ($request->hasFile('meta_image')) {
                $upload = $this->uploadFile($request->meta_image, 'course/meta_image/meta_image', [], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $courseModel->meta_image = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $courseModel->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Course created successfully.'), $courseModel); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        try {
            return $this->model->find($id);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $courseModel = $this->model->find($id);
            if (!$courseModel) {
                return $this->responseWithError(___('alert.Course not found.'), [], 400);
            }
            $courseModel->title = $request->title;
            if ($request->title != $courseModel->title) {
                $courseModel->slug = Str::slug($request->title) . '-' . Str::random(8);
            }
            $courseModel->course_type = $request->course_type;
            $courseModel->level_id = $request->course_level;
            $courseModel->short_description = $request->short_description;
            $courseModel->description = $request->description;
            $courseModel->course_category_id = $request->category;
            $courseModel->visibility_id = $request->visibility_id;
            $courseModel->status_id = $request->status_id ?? 1;
            $courseModel->language = $request->language_id;
            $courseModel->requirements = $request->requirements;
            $courseModel->outcomes = $request->outcomes;
            $courseModel->is_free = $request->is_free ?? 0;
            $courseModel->price = $request->price;
            if (@$request->is_discount) {
                $courseModel->is_discount = $request->is_discount ?? 10;
                $courseModel->discount_price = $request->discount_price ?? 10;
                $courseModel->discount_type = $request->discount_type;
            }
            $courseModel->course_overview_type = $request->course_preview ?? null;
            $courseModel->video_url = $request->video_url ?? null;
            $courseModel->meta_title = $request->meta_title;
            $courseModel->meta_keywords = $request->meta_keyword;
            $courseModel->meta_author = auth()->user()->name;
            $courseModel->meta_description = $request->meta_description;
            $courseModel->instructor_id = $request->instructor;
            $courseModel->partner_instructors = $request->partner_instructor;
            $courseModel->created_by = $request->instructor;
            $courseModel->updated_by = auth()->user()->id;
            // thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $upload = $this->uploadFile($request->thumbnail, 'course/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], $courseModel->thumbnail, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $courseModel->thumbnail = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            // meta image upload
            if ($request->hasFile('meta_image')) {
                $upload = $this->uploadFile($request->meta_image, 'course/meta_image/meta_image', [], $courseModel->meta_image, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $courseModel->meta_image = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            $courseModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess(___('alert.Course updated successfully.', $courseModel));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }
            $courseModel = $this->model->find($id);
            $upload = $this->deleteFile($courseModel->thumbnail, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $courseModel->delete();
            return $this->responseWithSuccess(___('alert.Course deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // Home API

    public function filterCourse($request, $data)
    {

        if ((setting('featured_courses') == 1) && ($request->course_type == 'featured')) {
            $featuredArr = $this->featuredCourse();
            return $data->whereIn('id', $featuredArr);
        }

        if ((setting('latest_courses') == 1) && ($request->course_type == 'latest')) {
            return $data->orderBy('id', 'desc');
        }

        if ((setting('best_rated_courses') == 1) && ($request->course_type == 'best_rated')) {
            return $data->where('rating', '>', 0)->orderBy('rating', 'desc');
        }

        if ((setting('best_selling_courses') == 1) && ($request->course_type == 'best_selling')) {
            return $data->where('total_sales', '>', 0)->orderBy('total_sales', 'desc');
        }

        if ((setting('free_courses') == 1) && ($request->course_type == 'free')) {
            return $data->where('is_free', 1);

        }

        if ((setting('discount_courses') == 1) && ($request->course_type == 'discount')) {
            return $data->where('is_discount', 11);
        }
    }

    public function homeSliders()
    {
        try {
            if (Cache::has('sliders')) {
                $sliders = Cache::get('sliders');
            } else {
                $sliders = $this->sliderModel->getAllSlider();
                Cache::put('sliders', $sliders);
            }

            return $sliders;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function featuredCourse()
    {
        try {
            if (Cache::has('featured_courses')) {
                $featuredCourses = Cache::get('featured_courses');
            } else {
                $featuredCourses = $this->featuredCourseModel->active()->with('course')->orderBy('id', 'ASC')->limit(8)->get();
                Cache::put('featured_courses', $featuredCourses);
            }
            return $featuredCourses;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function latestCourse()
    {
        try {
            if (Cache::has('latest_courses')) {
                $latest = Cache::get('latest_courses');
            } else {
                $latest = $this->model->active()->visible()->orderBy('id', 'DESC')->limit(8)->get();
                Cache::put('latest_courses', $latest);
            }
            return $latest;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function bestRatedCourses()
    {
        try {
            if (Cache::has('best_rated_courses')) {
                $courses = Cache::get('best_rated_courses');
            } else {
                $courses = $this->model->active()->visible()->orderBy('rating', 'DESC')->limit(8)->get();
                Cache::put('best_rated_courses', $courses);
            }
            return $courses;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function bestSellingCourses()
    {
        try {
            if (Cache::has('best_selling_course')) {
                $courses = Cache::get('best_selling_course');
            } else {
                $courses = $this->model->active()->visible()->orderBy('total_sales', 'DESC')->limit(8)->get();
                Cache::put('best_selling_course', $courses);
            }
            return $courses;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function freeCourses()
    {
        try {
            if (Cache::has('free_course')) {
                $courses = Cache::get('free_course');
            } else {
                $courses = $this->model->active()->visible()->where('is_free', 1)->limit(8)->get();
                Cache::put('free_course', $courses);
            }
            return $courses;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function discountCourses()
    {
        try {
            if (Cache::has('discount_courses')) {
                $courses = Cache::get('discount_courses');
            } else {
                $courses = $this->model->active()->visible()->orderBy('discount_price', 'DESC')->limit(8)->get();
                Cache::put('discount_courses', $courses);
            }
            return $courses;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getCourse($request, $allowArray)
    {
        try {
            $courseData = [
                'featured_courses' => [],
                'latest_courses' => [],
                'best_rated_courses' => [],
                'best_selling_courses' => [],
                'free_courses' => [],
                'discount_courses' => [],
            ];

            foreach($allowArray as $allow){
                switch($allow){
                    case 'featured_courses':
                                $courseData['featured_courses'] = new featuredCourseResource($this->featuredCourse());
                                break;
                    case 'latest_courses':
                                $courseData['latest_courses'] = new CourseResource($this->latestCourse());
                                break;
                    case 'best_rated_courses':
                                $courseData['best_rated_courses'] = new CourseResource($this->bestRatedCourses());
                                break;
                    case 'best_selling_courses':
                                $courseData['best_selling_courses'] = new CourseResource($this->bestSellingCourses());
                                break;
                    case 'free_courses':
                                $courseData['free_courses'] = new CourseResource($this->freeCourses());
                                break;
                    case 'discount_courses':
                                $courseData['discount_courses'] = new CourseResource($this->discountCourses());
                                break;
                    }
            }

            return $courseData ?? []; // return success response
        } catch (\Throwable $th) {
            return dd($th);
            return false;
        }
    }

    //End Home Api
}
