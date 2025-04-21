<?php

namespace Modules\Payment\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, StatusRelationTrait, SoftDeletes;

    protected $fillable = [];

    protected $guarded = ['id'];


    // active course
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    // image relation
    public function image()
    {
        return $this->belongsTo('App\Models\Upload', 'image_id');
    }

    // scope search
    public function scopeSearch($query, $request)
    {
        $where = [];
        if (@$request->search) {
            $where[] = ['title', 'like', '%' . @$request->search . '%'];
        }
        return $query->where($where);
    }
}
