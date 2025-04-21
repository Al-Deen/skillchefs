<?php

namespace Modules\Accounts\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, StatusRelationTrait, SoftDeletes;

    protected $fillable = ['is_default'];

    public function scopeSearch($query, $request)
    {
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return $query;
    }
}
