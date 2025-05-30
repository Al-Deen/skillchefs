<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;

class LiveSupport extends Model
{
    use HasFactory;
    protected $fillable = ['support_id', 'course_id', 'user_id', 'question', 'start_time', 'end_time', 'status'];

    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
