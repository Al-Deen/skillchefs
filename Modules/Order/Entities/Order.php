<?php

namespace Modules\Order\Entities;

use App\Models\User;
use Modules\Order\Entities\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status','payment_details','paid_amount','due_amount'];

    protected $casts = [
        'payment_manual' => 'array',
    ];

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // scope paid
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // order items relation
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    // order search
    public function scopeSearch($query, $req)
    {
        if (@$req) {
            return $query->where('invoice_number', 'like', '%' . @$req . '%');
        }
    }
}
