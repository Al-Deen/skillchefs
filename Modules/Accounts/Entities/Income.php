<?php

namespace Modules\Accounts\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    //relation with transaction
    public function transaction()
    {
        return $this->belongsTo('Modules\Accounts\Entities\Transaction');
    }

    public function scopeSearch($query, $request)
    {
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('transaction', function ($q) use ($request) {
                $q->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('account', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }
        return $query;
    }
}
