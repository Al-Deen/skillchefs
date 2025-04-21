<?php

namespace Modules\Course\Entities;

use App\Models\User;
use App\Models\Upload;
use Modules\Order\Entities\Enroll;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Assignment;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmit extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // relation with enroll
    public function enroll()
    {
        return $this->belongsTo(Enroll::class);
    }

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relation with assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // relation with upload
    public function assignmentFile()
    {
        return $this->belongsTo(Upload::class, 'assignment_file');
    }
}
