<?php

namespace Modules\Course\Entities;

use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [];

    // relation with course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // search
    public function scopeSearch($query, $req)
    {
        if (@$req->search) {
            return $query->whereHas('course', function ($query) use ($req) {
                $query->where('title', 'like', '%' . @$req->search . '%');
            });
        }
    }
}
