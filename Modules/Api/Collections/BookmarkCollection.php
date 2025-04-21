<?php
namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookmarkCollection extends ResourceCollection {
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            return [
                'id'                => @$data->course->id,
                'title'             => @$data->course->title,
                'price'             => !empty($data->course->price) ? $data->course->price : 0,
                'discount_price'    => !empty($data->course->discount_price) ? $data->course->discount_price : 0,
                'image'             => showImage(@$data->course->thumbnailImage->original, 'default-1.jpeg'),
                'rate'              => @$data->course->rating,
                'total_sales'       => @$data->course->total_sales ?? 0,
                'is_purchased'      => @auth()->user()->userCourseEnroll->where('course_id', @$data->course->id)->count() > 0,
            ];
        });
    }
}
