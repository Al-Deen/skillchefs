<?php

namespace Modules\Course\Entities;

use App\Models\User;
use Modules\Order\Entities\Enroll;
use Modules\Course\Entities\Lesson;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\QuestionSubmit;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizResult extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // relationship with lesson

    public function quiz()
    {
        return $this->belongsTo(Lesson::class, 'quiz_id');
    }

    // relationship with question submit

    public function questionSubmit()
    {
        return $this->hasMany(QuestionSubmit::class, 'quiz_result_id');
    }

    // relationship with user

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relationship with enroll
    public function enroll()
    {
        return $this->belongsTo(Enroll::class);
    }
}
