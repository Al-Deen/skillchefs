<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'courses' => $this->collection->map(function ($data) {
                return [
                    'id' => @$data->id,
                    'title' => @$data->title,
                    'price' => @$data->price,
                    'discount_price' => @$data->discount_price,
                    'thumbnail' => @$data->course->thumbnailImage->original,
                    'rating' => @$data->rating,
                    'total_sales' => @$data->total_sales,
                    'total_review' => @$data->total_review,
                    'is_free' => @$data->is_free,
                    'is_discount' => @$data->is_discount,
                    'created_at' => @$data->created_at,
                    'instructor' => @$data->instructor->name,
                    'category' => @$data->category,
                    'details' => route('home.api.course.details', @$data->id),
                ];
            })
        ];
    }
}
