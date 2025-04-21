<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{

    public function toArray($request)
    {

        return $this->resource->map(function ($data){
            return [
                'id'                => @$data->id,
                'title'             => @$data->title,
                'price'             => !empty($data->price) ? $data->price : 0,
                'discount_price'    => !empty($data->discount_price) ? $data->discount_price : 0,
                'image'             => showImage(@$data->thumbnailImage->original, 'default-1.jpeg'),
                'rate'              => @$data->rating,
                'total_sales'       => @$data->total_sales ?? 0,
                'reviewCount'       => !empty($data->total_review) ? $data->total_review : 0,
                'is_free'           => @$data->is_free,
                'is_discount'       => @$data->is_discount,
                'created_at'        => @$data->created_at,
                'course_creator'    => @$data->instructor->name,
                'details'           => route('home.api.course.details', @$data->id),
                'is_bookmark'       => @$data->userBookmark->count() > 0,
                'is_purchased'       => @auth()->user()->userCourseEnroll->where('course_id', @$data->id)->count() > 0,
            ];
        });
    }
}

