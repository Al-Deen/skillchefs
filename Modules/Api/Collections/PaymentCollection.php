<?php
namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            return [
                'id' => @$data->id,
                'title' => @$data->title,
                'name' => @$data->name,
                'image' => showImage('','payments/' . @$data->name . '.png'),
            ];
        });
    }
}
