<?php

namespace Modules\Course\Entities;

use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoticeBoard extends Model
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
}
