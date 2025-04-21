<?php

namespace Modules\Instructor\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstructorPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        'credentials' => 'array',
    ];

    // relation with payment method
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
