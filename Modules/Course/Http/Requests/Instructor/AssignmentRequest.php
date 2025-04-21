<?php

namespace Modules\Course\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'assignment_title' => 'required|max:255',
            'details' => 'nullable|max:3000',
            'marks' => 'required|numeric',
            'pass_marks' => 'required|numeric',
            'deadline' => 'required',
            'note' => 'nullable|max:2000',
            'status_id' => 'required|exists:statuses,id',
            'assignment_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
        ];
    }

    public function messages()
    {
        return [
            'assignment_title.required' => ___('validation.title_is_required'),
            'assignment_title.max' => ___('validation.title_must_be_less_than_255_characters'),
            'details.required' => ___('validation.details_is_required'),
            'details.max' => ___('validation.details_must_be_less_than_2000_characters'),
            'marks.required' => ___('validation.marks_is_required'),
            'marks.numeric' => ___('validation.marks_must_be_a_number'),
            'pass_marks.required' => ___('validation.pass_marks_is_required'),
            'pass_marks.numeric' => ___('validation.pass_marks_must_be_a_number'),
            'deadline.required' => ___('validation.deadline_is_required'),
            'deadline.date_format' => ___('validation.deadline_must_be_a_date_after_or_equal_to:today'),
            'note.max' => ___('validation.note_must_be_less_than_2000_characters'),
            'status_id.required' => ___('validation.status_is_required'),
            'status_id.exists' => ___('validation.status_is_not_exists'),
            'assignment_file.required' => ___('validation.assignment_file_is_required'),
            'assignment_file.file' => ___('validation.assignment_file_must_be_a_file'),
            'assignment_file.mimes' => ___('validation.assignment_file_must_be_a_file_of_type:pdf,doc,docx'),
            'assignment_file.max' => ___('validation.assignment_file_may_not_be_greater_than_20480_kilobytes'),

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
}
