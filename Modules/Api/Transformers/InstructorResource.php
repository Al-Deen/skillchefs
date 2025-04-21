<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Collections\InstructorCourseCollection;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => @$this->id,
            'Image' => showImage(@$this->user->image->original, 'default-1.jpeg'),
            'name' => @$this->user->name,
            'rating' => @$this->ratings() ?? 0,
            'course_count' => @$this->user->courses()->count(),
            'students_count' => @$this->courses->sum('total_sales'),
            'about' => [
                'designation' => @$this->designation,
                'experiences' => @$this->experience,
                'educations' => @$this->education,
            ],
            'courses' => new InstructorCourseCollection(@$this->courses),
            'reviews' => [
                'review_count' => @$this->totalReviews(),
                'rating' => @$this->ratings() ?? 0,
            ]
        ];
    }
}
