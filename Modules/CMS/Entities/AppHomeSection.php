<?php

namespace Modules\CMS\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppHomeSection extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = ['is_delete'];

    // booted
    protected static function booted()
    {
        static::created(function ($sections) { // when sections created then forget cache
            cache()->forget('sections');
        });
        
        static::saved(function ($sections) { // when sections created then forget cache
            cache()->forget('sections');
        });

        static::updated(function ($sections) { // when sections updated then forget cache
            cache()->forget('sections');
        });

        static::deleted(function ($sections) { // when sections deleted then forget cache
            cache()->forget('sections');
        });
    }

    // active
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    public function scopeSearch($query, $req)
    {
        if ($req->search) {
            return $query->where('title', "LIKE", "%{$req->search}%");
        }
    }

    public function scopeDelete($query)
    {
        return $query->where('is_delete', 1);
    }
}
