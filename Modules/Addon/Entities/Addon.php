<?php

namespace Modules\Addon\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // scopeFilter
    public function scopeFilter($query, $req)
    {
        $where = [];

        if (@$req->search && $req->search != 'undefined' && $req->search != 'null') {
            $query->where('TITLE', 'like', '%' . $req->search . '%');
        }
        return $query->where($where);
    }

}
