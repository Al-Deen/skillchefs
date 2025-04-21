<?php

namespace Modules\Course\Transformers;

use Modules\Course\Transformers\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class featuredCourseResource extends JsonResource
{
    protected $data;

    public function toArray($request)
    {
        return $this->resource->map(function ($data){
            return [
                'id'                => @$data->id,
                'title'             => @$data->course->title,
                'price'             => !empty($data->course->price) ? $data->course->price : 0,
                'discount_price'    => !empty($data->course->discount_price) ? $data->course->discount_price : 0,
                'image'             => showImage(@$data->course->thumbnailImage->original, 'default-1.jpeg'),
                'rate'              => @$data->course->rating,
                'total_sales'       => @$data->course->total_sales ?? 0,
                'reviewCount'       => !empty($data->course->total_review) ? $data->course->total_review : 0,
                'is_free'           => @$data->course->is_free,
                'is_discount'       => @$data->course->is_discount,
                'created_at'        => @$data->course->created_at,
                'course_creator'    => @$data->course->instructor->name,
                'details'           => route('home.api.course.details', @$data->course->id),
                'is_bookmark'       => @$data->course->userBookmark->count() > 0,
                'is_purchased'       => @auth()->user()->userCourseEnroll->where('course_id', @$data->course->id)->count() > 0,
            ];
        });
    }
}

