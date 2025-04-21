<?php

namespace Modules\Organization\Entities;

use App\Models\User;
use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstructorCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'user_id',
        'course_id',
        'commission',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

     // search by title
     public function scopeSearch($query, $req)
     {
         if (@$req->search) {
            return $query->whereHas('course', function ($query) use ($req) {
                $query->where('title', 'like', '%' .$req->search . '%');
            });
         }
     }

}
