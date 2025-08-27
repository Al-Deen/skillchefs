<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Bookmark;
use Modules\Course\Entities\CourseCategory;
use Modules\Instructor\Entities\Instructor;
use Modules\Order\Entities\Enroll;
use Modules\Order\Entities\OrderItem;

class Book extends Model
{
    use HasFactory;

    public $table = 'books';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'instructor_id',
        'point_title',
        'point_description',
        'description',
        'short_file',
        'full_file',
        'thumbnail',
        'price',
        'is_free',
        'status',
        'total_sales',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function shortFile()
    {
        return $this->belongsTo(Upload::class, 'short_file');
    }

    public function fullFile()
    {
        return $this->belongsTo(Upload::class, 'full_file');
    }

    public function thumbnailImage()
    {
        return $this->belongsTo(Upload::class, 'thumbnail');
    }

    public function scopeSearch($query, $req)
    {
        $where = [];

        if (@$req->instructor_id) {
            $where[] = ['instructor_id', @$req->instructor_id];
        }
        if (@$req->search) {
            $where[] = ['title', 'like', '%' . @$req->search . '%'];
        }

        if (@$req->status) {
            $where[] = ['status', @$req->status];
        }

        return $query->where($where);
    }






    // scope for discount course
    public function scopeDiscount($query)
    {
        return $query->where('is_discount', 11);
    }


    // course language relation
    public function lang()
    {
        return $this->belongsTo(Language::class, 'language', 'code');
    }



    // course scopeSlug
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // all student of course via enroll
    public function enrolls()
    {
        return $this->hasMany(Enroll::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function totalEnroll()
    {
        return $this->enrolls()->count();
    }

    public function totalReview()
    {
        return $this->reviews()->count();
    }

    public function totalAmountSales()
    {
        return @$this->orderItem()->with('order')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->sum('total_amount');
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function userBookmark()
    {
        return $this->hasMany(Bookmark::class)->where('user_id', auth()->id());
    }

}
