<?php

namespace Modules\Course\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Lesson;

class Section extends Model
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

    // lessons relationship
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->where('is_quiz', 0);
    }

    // quizzes relationship
    public function quizzes()
    {
        return $this->hasMany(Lesson::class)->where('is_quiz', 1);
    }

    public function allLesson()
    {
        return $this->hasMany(Lesson::class)->orderBy('order', 'asc');
    }
}
