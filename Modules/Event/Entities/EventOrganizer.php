<?php

namespace Modules\Event\Entities;

use App\Models\Status;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\Event;

class EventOrganizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image_id',
        'event_id',
        'status_id',
    ];

    // event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); // 'Active = 1, Inactive = 2
    }

    // profile image
    public function image()
    {
        return $this->belongsTo(Upload::class);
    }

    protected static function newFactory()
    {
        return \Modules\Event\Database\factories\EventOrganizerFactory::new ();
    }
}
