<?php

namespace Modules\Event\Entities;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\EventSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventScheduleList extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Event\Database\factories\EventScheduleListFactory::new();
    }

    // status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); // Active = 1, Inactive = 2
    }

    // schedule
    public function schedule()
    {
        return $this->belongsTo(EventSchedule::class, 'event_schedule_id');
    }
}
