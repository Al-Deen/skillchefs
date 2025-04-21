<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\QuestionSubmit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        'options' => 'array',
        'answer' => 'array'
    ];

    // relationship with lesson

    public function quiz()
    {
        return $this->belongsTo(Lesson::class, 'quiz_id');
    }

    // relationship with question submit

    public function questionSubmits()
    {
        return $this->hasMany(QuestionSubmit::class, 'question_id');
    }

    // relationship with answer

    public function userAnswer()
    {
        return $this->hasOne(QuestionSubmit::class, 'question_id')->where('user_id', auth()->id())->select('answer','is_correct');
    }

    public function submitAnswer($query, $user_id)
    {
        return $query->questionSubmits()->where('user_id', $user_id)->select('answer','is_correct')->first();
    }
}
