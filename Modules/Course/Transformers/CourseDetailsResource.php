<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => @$this->id,
            'title' => @$this->title,
            'thumbnail_image' => showImage(@$this->thumbnailImage->original, 'default-1.jpeg'),
            'video_url' => @$this->video_url,
            'creator_img' => showImage(@$this->user->image->original, 'default-1.jpeg'),
            'creator_name' => @$this->instructor->name,
            'creator_title' => @$this->user->instructor->designation,
            'rating' => @$this->rating,
            'ratings_count' => @$this->totalReview(),
            'student_count' => @$this->totalEnroll(),
            'course_short_description' =>@$this->short_description,
            'price' => @$this->price,
            'is_discount' => @$this->is_discount,
            'discount_type' => @$this->discount_type,
            'discount_price' => @$this->discount_price,
            'created_at' => showDate($this->created_at) ,
            'learn_description' => @$this->description,
            'is_bookmark' => @$this->userBookmark->count() > 0,
            'is_purchased'       => @auth()->user()->userCourseEnroll->where('course_id', @$this->id)->count() > 0,
            'slug' => @$this->slug,
            'requirements' => @$this->requirements ?? '',
        ];
    }
}
