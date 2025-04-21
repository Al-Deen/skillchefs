<?php

namespace Modules\CMS\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedCourse extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // booted
    protected static function booted()
    {
        static::created(function ($featured_courses) { // when featured_courses created then forget cache
            cache()->forget('featured_courses');
        });
        
        static::saved(function ($featured_courses) { // when featured_courses created then forget cache
            cache()->forget('featured_courses');
        });

        static::updated(function ($featured_courses) { // when featured_courses updated then forget cache
            cache()->forget('featured_courses');
        });

        static::deleted(function ($featured_courses) { // when featured_courses deleted then forget cache
            cache()->forget('featured_courses');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    // relation with course
    public function course()
    {
        return $this->belongsTo('Modules\Course\Entities\Course')->active()->visible();
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('course', function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%');
        });
    }
}
