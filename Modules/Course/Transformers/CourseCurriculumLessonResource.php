<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseCurriculumLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->map(function ($lesson) {
            return [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'is_quiz'  => $lesson->is_quiz,
                'lesson_type' => @$lesson->lesson_type ?? '',
            ];
        });
    }
}
