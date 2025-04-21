<?php

namespace Modules\Event\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'event_type' => 'required',
            'max_participant' => 'required',
            'tags' => 'required',
            'is_paid' => 'required',
            'price' => 'required_if:is_paid,11',
            'event_duration' => 'required',
            'visibility_id'=>'required',
            'category'=>'required',
            'address' => 'required_if:event_type,Offline|max:255',
            'online_media' => 'required_if:event_type,Online|max:255',
            'online_link' => ['required_if:event_type,Online','regex:/^(http|https):\/\/([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}(\/\S*)?$/', 'max:255'],
            'online_note' => 'required_if:event_type,Online',
            'online_welcome_media' => 'required_if:event_type,Online|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'             => ___('event.title is required'),
            'title.max'                  => ___('event.title must be less than 255 characters'),
            'description.required'       => ___('event.description is required'),
            'thumbnail.required'         => ___('event.thumbnail is required'),
            'thumbnail.image'            => ___('event.thumbnail must be an image'),
            'thumbnail.mimes'            => ___('event.thumbnail must be a JPEG, PNG, JPG, GIF, or SVG file'),
            'thumbnail.max'              => ___('event.thumbnail size should not exceed 1024 KB'),
            'event_type.required'        => ___('event.event_type is required'),
            'max_participant.required'   => ___('event.max_participant is required'),
            'tags.required'              => ___('event.tags are required'),
            'is_paid.required'           => ___('event.this field is required'),
            'price.required_if'          => ___('event.price is required when it is paid event'),
            'category.required'          => ___('event.category is required'),
            'visibility_id.required'     => ___('event.visibility is required'),

            'address.required_if'               => ___('event.address is required'),
            'address.max'                       => ___('event.address must be less than 255 characters'),
            'online_media.required_if'          => ___('event.online media is required'),
            'online_media.max'                  => ___('event.online media must be less than 255 characters'),
            'online_link.required_if'           => ___('event.online link is required'),
            'online_link.regex'                 => ___('event.online link url is not valid'),
            'online_link.max'                   => ___('event.online link must be less than 255 characters'),
            'online_note.required_if'           => ___('event.online note is required'),
            'online_note.max'                   => ___('event.online note must be less than 255 characters'),
            'online_welcome_media.required_if'  => ___('event.online welcome media is required'),
            'online_welcome_media.max'          => ___('event.online welcome media must be less than 255 characters'),
        ];
    }
}
