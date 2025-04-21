<?php
namespace Modules\Api\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssignmentCollection extends ResourceCollection {
    public function toArray($request)
    {
        return $this->collection->map(function ($assignment) {
            return [
                "id" => $assignment->id,
                "title" => $assignment->title,
                "details" => $assignment->details,
                "course_title" => $assignment->course->title,
                "marks" => $assignment->marks,
                "deadline" => showDate($assignment->deadline),
                "status" => @$assignment->submit()->value('is_submitted') == 11 ? 'Submitted' : (date('Y-m-d H:i:s') > $assignment->deadline ? 'Expired' : 'Not Submitted'),
            ];
        });
    }
}
