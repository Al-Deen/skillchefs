<?php

namespace Modules\Course\Entities;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\AssignmentSubmit;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];


    // Course relationship
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // search by title
    public function scopeSearch($query, $req)
    {
        $where = [];
        if (@$req->search) {
            $where[] = ['title', 'like', '%' . @$req->search . '%'];
        }
        return $query->where($where);

    }

    // relation with upload
    public function assignmentFile()
    {
        return $this->belongsTo(Upload::class, 'assignment_file');
    }

    // relation with assignment submit
    public function assignmentSubmit()
    {
        return $this->hasMany(AssignmentSubmit::class);
    }

    public function scopeSubmit()
    {
        return $this->hasMany(AssignmentSubmit::class)->where('user_id', auth()->id())->where('is_submitted',11);
    }

}
