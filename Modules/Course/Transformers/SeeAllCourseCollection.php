<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeeAllCourseCollection extends ResourceCollection
{
    protected $data;
    protected $bookMarksArr;

    public function __construct($data, $bookMarksArr)
    {
        $this->data = $data;
        $this->bookMarksArr = $bookMarksArr;
    }

    public function toArray($request)
    {

        return [

            'courses' => $this->data->map(function ($data) {

                return [
                    'id'                => @$data->course->id,
                    'title'             => @$data->course->title,
                    'price'             => !empty($data->course->price) ? $data->course->price : 0,
                    'discount_price'    => !empty($data->course->discount_price) ? $data->course->discount_price : 0,
                    'image'             => showImage($data->course->thumbnailImage->original, 'default-1.jpeg'),
                    'rate'              => @$data->course->rating,
                    'total_sales'       => @$data->course->total_sales ?? 0,
                    'reviewCount'       => !empty($data->course->total_review) ? $data->course->total_review : 0,
                    'is_free'           => @$data->course->is_free,
                    'is_discount'       => @$data->course->is_discount,
                    'created_at'        => @$data->course->created_at,
                    'course_creator'    => @$data->course->instructor->name,
                    'details'           => route('home.api.course.details', @$data->course->id),
                    'is_bookmark'       => in_array(@$data->course->id,$this->bookMarksArr) ? true : false,
                    'is_purchased'      => @auth()->user()->userCourseEnroll->where('course_id', @$data->course->id)->count() > 0,
                ];
            }),

            'pagination' => [
                'total' => $this->data->total(),
                'count' => $this->data->count(),
                'per_page' => $this->data->perPage(),
                'current_page' => $this->data->currentPage(),
                'total_pages' => $this->data->lastPage()
            ]
        ];

    }
}
