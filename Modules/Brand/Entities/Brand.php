<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];


    // image relation with upload
    public function iconImage():BelongsTo
    {
        return $this->belongsTo('App\Models\Upload', 'image_id');
    }

     // active
     public function scopeActive($query)
     {
         return $query->where('status_id', 1);
     }

}
