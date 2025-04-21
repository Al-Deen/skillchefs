<?php

namespace Modules\Order\Entities;

use Modules\Course\Entities\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [];

    // relation with lesson
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id' );
    }
}
