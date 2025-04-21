<?php

namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function($data){
            return [
                'id' => @$data->id,
                'title' => @$data->title,
                'slug' => @$data->slug,
                'icon' => showImage(@$data->iconImage()->first()->original, 'default-1.jpeg'),
            ];
        });
    }
}

