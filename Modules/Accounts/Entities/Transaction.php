<?php

namespace Modules\Accounts\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // relation with user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // relation with account
    public function account()
    {
        return $this->belongsTo('Modules\Accounts\Entities\Account');
    }

    public function scopeSearch($query, $request)
    {
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('account', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        return $query;
    }
}
