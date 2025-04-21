<?php

namespace Modules\Event\Entities;

use App\Models\Status;
use Modules\Event\Entities\Event;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\EventScheduleList;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventSchedule extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Event\Database\factories\EventScheduleFactory::new();
    }

    // event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); //Active = 1, Inactive = 2
    }

    // schedule
    public function scheduleList()
    {
        return $this->hasMany(EventScheduleList::class, 'event_schedule_id')->orderBy('from_time');
    }

    // Active schedule
    public function activeScheduleList()
    {
        return $this->hasMany(EventScheduleList::class, 'event_schedule_id')->where('status_id', 1)->orderBy('from_time');
    }
}
