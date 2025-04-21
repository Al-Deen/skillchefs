<?php

namespace Modules\Api\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'title' => @$this->title,
            'slug' => @$this->slug,
            'icon' => showImage(@$this->icon, 'default-1.jpeg'),
        ];
    }
}
