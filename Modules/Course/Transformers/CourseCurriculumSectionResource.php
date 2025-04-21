<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Transformers\CourseCurriculumLessonResource;

class CourseCurriculumSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->sections->map(function ($section) {
            return [
                'id' => $section->id,
                'section_name' => $section->title,
                'lessons' => new CourseCurriculumLessonResource($section->lessons),
            ];
        });
    }
}
