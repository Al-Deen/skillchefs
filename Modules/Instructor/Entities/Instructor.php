<?php

namespace Modules\Instructor\Entities;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Course\Entities\Course;
use Modules\Instructor\Entities\InstructorPaymentMethod;
use Modules\Instructor\Entities\Payout;
use Modules\Order\Entities\Enroll;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'balance', 'earings',
    ];

    public $casts = [
        'education' => 'json',
        'experience' => 'json',
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

    // relation with default payment method
    public function paymentMethod()
    {
        return $this->hasMany(InstructorPaymentMethod::class, 'user_id', 'user_id');
    }

    // relation with payout
    public function payouts()
    {
        return $this->hasMany(Payout::class, 'user_id', 'user_id');
    }

    // relation with course
    public function courses()
    {
        return $this->hasMany(Course::class, 'created_by', 'user_id');
    }

    // scopeFilter
    public function scopeFilter($query, $req)
    {
        $where = [];

        if (@$req->search && $req->search != 'undefined' && $req->search != 'null') {
            $query->whereHas('user', function ($query) use ($req) {
                $query->where('name', 'like', '%' . $req->search . '%');
            });
        }
        // start filter for array value
        if (@$req->languages) {
            $query->whereHas('courses', function ($query) use ($req) {
                $query->whereIn('language', explode(',', $req->languages));
            });
        }

        if (@$req->categories) {
            $query->whereHas('courses', function ($query) use ($req) {
                $query->whereIn('course_category_id', explode(',', $req->categories));
            });
        }

        if (@$req->course_level) {
            $query->whereHas('courses', function ($query) use ($req) {
                $query->whereIn('level_id', explode(',', $req->course_level));
            });
        }

        if (@$req->ratings) {
            $ratings = explode(',', $req->ratings);
            $query->whereHas('courses', function ($query) use ($ratings) {
                $query->where(function ($query) use ($ratings) {
                    foreach ($ratings as $rating) {
                        $query->orWhere('rating', '>=', $rating);
                    }
                });
            });
        }
        return $query->where($where);
    }

    public function ratings()
    {
        return $this->courses()->sum('rating') > 0 ? $this->courses()->sum('rating') / $this->courses()->where('rating', '>', 0)->count() : 0;
    }

    public function enroll(): HasMany
    {
        return $this->hasMany(Enroll::class, 'instructor_id', 'user_id');
    }

    public function totalReviews()
    {
        return $this->courses()->sum('total_review');
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
}
