<?php

namespace Modules\Slider\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    protected static function booted()
    {
        static::saved(function ($sliders) { // when slider created then forget cache
            cache()->forget('sliders');
        });
        
        static::created(function ($sliders) { // when slider created then forget cache
            cache()->forget('sliders');
        });

        static::updated(function ($slider) { // when slider updated then forget cache
            cache()->forget('sliders');
        });

        static::deleted(function ($slider) { // when slider deleted then forget cache
            cache()->forget('sliders');
        });
    }

    // image relation with upload
    public function iconImage(): BelongsTo
    {
        return $this->belongsTo('App\Models\Upload', 'image_id');
    }

    // active
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

}
