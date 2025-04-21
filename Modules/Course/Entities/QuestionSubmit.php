<?php

namespace Modules\Course\Entities;

use Modules\Course\Entities\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionSubmit extends Model
{
    use HasFactory;

    protected $fillable = [];

    // relation with question

    protected $casts = [
        'answer' => 'array'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
