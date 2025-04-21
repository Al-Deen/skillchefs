<?php

namespace App\Models;

use App\Models\Designation;
use App\Models\Role;
use App\Models\Status;
use App\Models\Upload;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Course\Entities\Assignment;
use Modules\Instructor\Entities\Instructor;
use Modules\Student\Entities\Student;
use Modules\ZoomMeeting\Entities\ZoomSetting;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image_id',
        'password',
        'email_verified_at',
        'phone',
        'permission',
        'last_login',
        'designation_id',
        'status',
        'facebook_id',
        'google_id',
        'github_id',
        'linkedin_id',
        'event_commission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Upload::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'created_by');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function purchaseCourses()
    {
        return $this->hasMany('Modules\Order\Entities\Enroll', 'user_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany('Modules\Course\Entities\Course', 'created_by');
    }

    public function courseEnroll()
    {
        return $this->hasMany('Modules\Order\Entities\Enroll', 'instructor_id', 'id');
    }

    public function userStatus()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function bookmarks()
    {
        return $this->hasMany('Modules\Course\Entities\Bookmark', 'user_id', 'id');
    }

    public function userCourseEnroll()
    {
        return $this->hasMany('Modules\Order\Entities\Enroll', 'user_id', 'id');
    }

    // for zoom

    public function zoomSetting()
    {
        return $this->hasOne(ZoomSetting::class, 'user_id', 'id');
    }

    // organization
    public function organization()
    {
        return $this->hasOne(\Modules\Organization\Entities\Organization::class);
    }
}
