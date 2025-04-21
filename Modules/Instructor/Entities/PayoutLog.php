<?php

namespace Modules\Instructor\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Instructor\Entities\Payout;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayoutLog extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // relation with payout
    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
