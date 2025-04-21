<?php

namespace Modules\Event\Entities;

use App\Models\User;
use App\Models\Status;
use Modules\Event\Entities\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'price',
        'status',
        'payment_method',
        'payment_details',
        'status_id'
    ];

    protected $casts = [
        'payment_manual' => 'array',
    ];

    // event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); // Approve = 4, Pending = 3, Paid = 8, Unpaid = 9
    }

    // ticket buyer's id
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // search by title
    public function scopeSearch($query, $req)
    {
        if (@$req->search) {
            return $query->whereHas('event', function ($query) use ($req) {
                $query->where('title', 'like', '%' .$req->search . '%');
            });
        } elseif (@$req->participant) {
            return $query->whereHas('user', function ($query) use ($req) {
                $query->where('name', 'like', '%' .$req->participant . '%');
            });
        } elseif(@$req->invoice){
            return $query->where('invoice_number', 'like', '%' . @$req->invoice . '%');
        }
    }
}
