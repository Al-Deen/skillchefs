<?php

namespace Modules\Event\Entities;

use App\Models\Status;
use Modules\Event\Entities\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = [];



    // relation with event
    public function events()
    {
        return $this->hasMany(Event::class, 'event_id');
    }

    // status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); // 'Active = 1, Inactive = 2
    }

    // active Question
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    // search by title
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%');
    }

}
