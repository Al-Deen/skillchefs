<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'userId' => @$this->id,
            'name' => @$this->name,
            'email' => @$this->email,
            'mobile' => @$this->phone,
            'avatar' => showImage(@$this->image->original),
            'status_id' => @$this->userStatus->id,
            'status' => @$this->userStatus->name,
            'date_of_birth' => @$this->student->date_of_birth,
            'joinDate' => showDate(@$this->created_at) ,
            'verification_setup' =>  verificationSetup(),
        ];
    }
}
