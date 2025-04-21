<?php

namespace Modules\Instructor\Entities;

use App\Models\User;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Modules\Instructor\Entities\PayoutLog;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Instructor\Entities\InstructorPaymentMethod;

class Payout extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = ['status_id','payment_details'];

    // relation with payout method
    public function instructorPaymentMethod()
    {
        return $this->belongsTo(InstructorPaymentMethod::class);
    }

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relation with payout log
    public function payoutLog()
    {
        return $this->hasMany(PayoutLog::class);
    }

    // search
    public function scopeSearch($query, $request)
    {
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        return $query;
    }

    // payout status
    public function payment_status()
    {
        return $this->belongsTo(Status::class, 'payment_status_id', 'id');
    }
}
