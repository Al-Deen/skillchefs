<?php

namespace Modules\Blog\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Entities\BlogCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, StatusRelationTrait, SoftDeletes;

    protected $fillable = [
            'title',
            'status_id',
            'blog_categories_id',
            'image_id',
            'description',
    ];


    // search by title
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%');
    }

     // active
     public function scopeActive($query)
     {
         return $query->where('status_id', 1);
     }

    // image relation with upload
    public function iconImage():BelongsTo
    {
        return $this->belongsTo('App\Models\Upload', 'image_id');
    }

    // image relation with upload
    public function metaImage():BelongsTo
    {
        return $this->belongsTo('App\Models\Upload', 'meta_image_id');
    }

    public function category() :BelongsTo {
        return $this->belongsTo(BlogCategory::class,'blog_categories_id');
    }

    public function user() :BelongsTo {
        return $this->belongsTo(User::class,'created_by');
    }






}
