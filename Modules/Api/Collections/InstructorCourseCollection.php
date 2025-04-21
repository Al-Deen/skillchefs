<?php
namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InstructorCourseCollection extends ResourceCollection{
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            return [
                'id' => @$data->id,
                'image' => showImage(@$data->thumbnailImage->original, 'default-1.jpeg'),
                'title' => @$data->title,
                'rating' => @$data->rating,
                'total_review' => @$data->reviews->count(),
                'is_bookmark' => @$data->userBookmark->count() > 0,
                'is_purchased'  => auth()->user()->userCourseEnroll->where('course_id', @$data->id)->count() > 0,
            ];
        });
    }
}
