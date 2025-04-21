<?php

namespace Modules\Course\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseCategory extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'user_id',
        'status_id',
    ];

    // booted
    protected static function booted()
    {
        static::created(function ($menu_categories) { // when menu_categories created then forget cache
            cache()->forget('menu_categories');
            cache()->forget('popular_course_category');
        });

        static::saved(function ($menu_categories) { // when menu_categories created then forget cache
            cache()->forget('menu_categories');
            cache()->forget('popular_course_category');
            cache()->forget('instructor_categories');
        });

        static::updated(function ($menu_categories) { // when menu_categories updated then forget cache
            cache()->forget('menu_categories');
            cache()->forget('popular_course_category');
        });
        static::created(function ($instructor_categories) { // when instructor_categories created then forget cache
            cache()->forget('instructor_categories');
        });

        static::updated(function ($instructor_categories) { // when instructor_categories updated then forget cache
            cache()->forget('instructor_categories');
        });

        static::deleted(function ($instructor_categories) { // when instructor_categories deleted then forget cache
            cache()->forget('menu_categories');
            cache()->forget('popular_course_category');
        });
    }

    // parent category
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id');
    }

    // child category
    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }

    // Course
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    // search by title
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%');
    }

    // active course
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    // image relation with upload
    public function iconImage(): BelongsTo
    {
        return $this->belongsTo('App\Models\Upload', 'icon');
    }

    // popular category
    public function scopePopular($query)
    {
        return $query->where('is_popular', 1);
    }

}
