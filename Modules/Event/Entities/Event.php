<?php

namespace Modules\Event\Entities;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Status;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\EventSpeaker;
use Modules\Event\Entities\EventCategory;
use Modules\Event\Entities\EventSchedule;
use Modules\Event\Entities\EventOrganizer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Event\Entities\EventRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    // relation with upload
    public function image()
    {
        return $this->belongsTo(Upload::class, 'thumbnail');
    }

    // relation with category
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    // status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id'); // Approve = 4, Pending = 3, Reject = 6, Draft = 21
    }

    public function visibleStatus()
    {
        return $this->belongsTo(Status::class, 'visibility_id'); // Approve = 4, Pending = 3, Reject = 6, Draft = 21
    }

    // visible course
    public function scopeVisible($query)
    {
        return $query->where('visibility_id', 22);
    }

    public function scopeActive()
    {
        return $this->where('status_id', 4);
    }

    // event creator
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Event Type Status
    public function isPaid()
    {
        if ($this->is_paid == 11) {
            return showPrice($this->price);
        } elseif ($this->is_paid == 10) {
            return 'Free';
        }
    }

    // register
    public function register()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function register_student()
    {
        return $this->hasOne(EventRegistration::class)->where('user_id', auth()->user()->id);
    }


    public function paid_register_student()
    {
        return $this->hasOne(EventRegistration::class)->where('user_id', auth()->user()->id)->where('status', 'paid')->orderBy('id','desc');
    }

    public function register_income()
    {
        return $this->hasMany(EventRegistration::class, 'event_id')->select(DB::raw('SUM(instructor_commission) as income'));
    }

    public function participants()
    {
        return $this->hasMany(EventRegistration::class, 'event_id')->orderBy('created_at', 'asc')->take(31);
    }

    // Event Schedule
    public function schedule()
    {
        return $this->hasMany(EventSchedule::class, 'event_id');
    }

    // Active Event Schedule
    public function activeSchedule()
    {
        return $this->hasMany(EventSchedule::class, 'event_id')->where('status_id', 1)->orderBy('date');
    }

    // organizer
    public function organizer()
    {
        return $this->hasMany(EventOrganizer::class, 'event_id');
    }

    // speaker
    public function speaker()
    {
        return $this->hasMany(EventSpeaker::class, 'event_id');
    }

    // search by title
    public function scopeSearch($query, $req)
    {
        $where = [];
        if (@$req->search) {
            $where[] = ['title', 'like', '%' . @$req->search . '%'];
        }
        if (@$req->location && @$req->location != '') {
            $where[] = ['address', 'like', '%' . @$req->location . '%'];
        }
        if (@$req->category_id) {
            $where[] = ['category_id', @$req->category_id];
        }
        if (@$req->event_type) {
            $where[] = ['event_type', @$req->event_type];
        }
        return $query->where($where);
    }

    // date time
    public function startDateTime()
    {
        return $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->start);
    }

    public function endDateTime()
    {
        return $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->end);
    }

    public function deadlineDateTime()
    {
        return $deadlineDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->registration_deadline);
    }

    // show participant
    public function participant_status()
    {
        return $this->belongsTo(Status::class, 'show_participant'); // Public = 22, Private = 23
    }

    protected static function newFactory()
    {
        return \Modules\Event\Database\factories\EventFactory::new ();
    }

    public function scopePending($query)
    {
        return $query->where('status_id', 3);
    }

    public function scopeApproved($query)
    {
        return $query->where('status_id', 4);
    }

    public function scopeRejected($query)
    {
        return $query->where('status_id', 6);
    }
}
