<?php

namespace Modules\CMS\Entities;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageGallery extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = ['title','slug','status_id'];

    // booted
    protected static function booted()
    {
        static::created(function ($galleries) { // when galleries created then forget cache
            cache()->forget('galleries');
        });

        static::saved(function ($galleries) { // when galleries created then forget cache
            cache()->forget('galleries');
        });

        static::updated(function ($galleries) { // when galleries updated then forget cache
            cache()->forget('galleries');
        });

        static::deleted(function ($galleries) { // when galleries deleted then forget cache
            cache()->forget('galleries');
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
