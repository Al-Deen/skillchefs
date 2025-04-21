<?php
namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InstructorCollection extends ResourceCollection{
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            return [
                'id' => @$data->id,
                'name' => @$data->user->name,
                'role' => 'Instructor',
                'email' => @$data->user->email,
                'bio' => @$data->about_me,
                'rating' => @$data->ratings() ?? 0,
                'image' => showImage(@$data->user->image->original, 'default-1.jpeg'),
            ];
        });
    }
}
