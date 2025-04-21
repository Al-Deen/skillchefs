<?php

namespace Modules\Organization\Entities;

use App\Models\Country;
use App\Models\User;
use Modules\Organization\Entities\InstructorCommission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Instructor\Entities\Payout;
use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use Modules\Instructor\Entities\InstructorPaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Entities\Enroll;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_me',
        'designation',
        'address',
        'gender',
        'date_of_birth',
        'badges',
        'skills',
        'earnings',
        'balance',
        'points',
        'country_id',
        'user_id',
        'status_id',
    ];

    public $casts = [
        'skills' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'created_by', 'user_id');
    }

    // scopeFilter
    public function scopeSearch($query, $req)
    {
        if (@$req->search) {
            return $query->whereHas('user', function ($query) use ($req) {
                $query->where('name', 'like', '%' . @$req->search . '%');
            });
        }
    }

    public function scopeActive()
    {
        return $this->whereHas('user', function ($query) {
            $query->where('status_id', 4);
        });
    }

    public function scopeInactive()
    {
        return $this->whereHas('user', function ($query) {
            $query->where('status_id', 5);
        });
    }

    public function scopePending()
    {
        return $this->whereHas('user', function ($query) {
            $query->where('status_id', 3);
        });
    }

    public function scopeSuspended()
    {
        return $this->whereHas('user', function ($query) {
            $query->where('status_id', 5);
        });
    }

    // relation with payout
    public function payouts()
    {
        return $this->hasMany(Payout::class, 'user_id', 'user_id');
    }
    // relation with default payment method
    public function paymentMethod()
    {
        return $this->hasMany(InstructorPaymentMethod::class, 'user_id', 'user_id');
    }

    // ratings
    public function ratings()
    {
        return $this->courses()->sum('rating') > 0 ? $this->courses()->sum('rating') / $this->courses()->where('rating', '>', 0)->count() : 0;
    }

    // reviews
    public function totalReviews()
    {
        return $this->courses()->sum('total_review');
    }

    public function enroll(): HasMany
    {
        return $this->hasMany(Enroll::class, 'instructor_id', 'user_id');
    }
}
