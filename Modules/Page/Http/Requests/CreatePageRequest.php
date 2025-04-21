<?php

namespace Modules\Page\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // echo "<pre>";print_r($this->all());exit;

        $rule = [
            'title' => 'required|max:80|unique:pages,title,' . $this->id,
            'status_id' => 'required|max:30',
            'type' => 'required|max:30',
            'section' => 'array|nullable|max:255',
            'section.*' => 'string|nullable|max:255',
        ];
        if (@request()->type == 1) {
            $rule['content'] = 'required|string';
        } else if (@request()->type == 2) {
            $rule['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } else {
            $rule['widget_type'] = 'required|string';
            $rule['content'] = 'required|string';
            $rule['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        return $rule;
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

    public function messages()
    {
        return [

            'title.required' => ___('validation.title_field_is_required'),
            'title.max' => ___('validation.title_field_must_be_less_than_80_characters'),
            'status_id.required' => ___('validation.status_is_required'),
            'status_id.max' => ___('validation.status_must_be_less_than_30_characters'),
            'content.required' => ___('validation.content_field_is_required'),
            'content.string' => ___('validation.content_field_must_be_string'),
            'image.required' => ___('validation.image_field_is_required'),
            'image.image' => ___('validation.image_field_must_be_image'),
            'image.mimes' => ___('validation.image_field_must_be_image_type'),
            'image.max' => ___('validation.image_field_must_be_less_than_2048_kb'),
            'section.array' => ___('validation.section_field_must_be_array'),
            'section.max' => ___('validation.section_field_must_be_less_than_255_characters'),
            'section.*.string' => ___('validation.section_field_must_be_string'),
            'section.*.max' => ___('validation.section_field_must_be_less_than_255_characters'),
        ];
    }

}
