<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // dd();
        return $this->collection->map(function ($data) {
                return [
                    'id' => @$data->id,
                    'title' => @$data->title,
                    'sub_title' => @$data->sub_title,
                    'description' => @$data->description,
                    'serial' => @$data->serial,
                    'image' => showImage(@$data->iconImage->original, 'backend/uploads/default-images/hero/hero'. rand(1,3) .'.jpg'),
                ];
            });
    }
}
