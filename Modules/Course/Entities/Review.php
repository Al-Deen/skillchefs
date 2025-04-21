<?php

namespace Modules\Course\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [];

    // user relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->whereHas('course', function ($query) {
            $query->where('created_by', auth()->id());
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('course', function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->orWhere('comment', 'like', '%' . $search . '%');
    }
}
