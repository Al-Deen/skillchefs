<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;

class Support extends Model
{
    use HasFactory;
    public $table = 'supports';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'course_id',
        'support_link',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
