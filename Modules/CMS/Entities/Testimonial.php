<?php

namespace Modules\CMS\Entities;

use App\Models\Upload;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // booted
    protected static function booted()
    {
        static::created(function ($testimonials) { // when testimonials created then forget cache
            cache()->forget('testimonials');
        });
        
        static::saved(function ($testimonials) { // when testimonials created then forget cache
            cache()->forget('testimonials');
        });

        static::updated(function ($testimonials) { // when testimonials updated then forget cache
            cache()->forget('testimonials');
        });

        static::deleted(function ($testimonials) { // when testimonials deleted then forget cache
            cache()->forget('testimonials');
        });


    }

    public function scopeSearch($query, $request)
    {
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return $query;
    }

    public function image()
    {

        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }
}
