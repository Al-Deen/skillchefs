<?php

namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CertificateCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function($data){
            return [
                'id' => @$data->id,
                'title' => @$data->enroll->course->title,
                'description' => @$data->enroll->course->short_description,
                'image' => showImage(@$data->image->original,'default-1.jpeg'),
            ];
        });
    }
}

