<?php

namespace Modules\Course\Entities;

use App\Models\Language;
use App\Models\Status;
use App\Models\User;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Bookmark;
use Modules\Course\Entities\CourseCategory;
use Modules\Order\Entities\Enroll;
use Modules\Order\Entities\OrderItem;

class Course extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'course_category_id',
        'status',
        'created_by',
        'updated_by',
        'rating',
        'total_review',
        'total_sales',

    ];

    protected $casts = [
        'partner_instructors' => 'array',
    ];

    // booted
    protected static function booted()
    {

        static::saved(function ($courses) { // when slider created then forget cache
            cache()->forget('instructor_languages');
            cache()->forget('featured_courses');
            cache()->forget('latest_courses');
            cache()->forget('best_rated_courses');
            cache()->forget('best_selling_course');
            cache()->forget('free_course');
            cache()->forget('most_popular_courses');
            cache()->forget('discount_courses');
        });

        static::created(function ($courses) { // when courses created then forget cache
            cache()->forget('instructor_languages');
            cache()->forget('featured_courses');
            cache()->forget('latest_courses');
            cache()->forget('best_rated_courses');
            cache()->forget('best_selling_course');
            cache()->forget('free_course');
            cache()->forget('most_popular_courses');
            cache()->forget('discount_courses');
        });

        static::updated(function ($courses) { // when courses updated then forget cache
            cache()->forget('instructor_languages');
            cache()->forget('featured_courses');
            cache()->forget('latest_courses');
            cache()->forget('best_rated_courses');
            cache()->forget('best_selling_course');
            cache()->forget('free_course');
            cache()->forget('most_popular_courses');
            cache()->forget('discount_courses');
        });

        static::deleted(function ($courses) { // when courses deleted then forget cache
            cache()->forget('instructor_languages');
            cache()->forget('featured_courses');
            cache()->forget('latest_courses');
            cache()->forget('best_rated_courses');
            cache()->forget('best_selling_course');
            cache()->forget('free_course');
            cache()->forget('most_popular_courses');
            cache()->forget('discount_courses');
        });
    }

    // search by title
    public function scopeSearch($query, $req)
    {
        $where = [];

        if (@$req->instructor_id) {
            $where[] = ['created_by', @$req->instructor_id];
        }
        if (@$req->search) {
            $where[] = ['title', 'like', '%' . @$req->search . '%'];
        }
        if (@$req->category) {
            $where[] = ['course_category_id', @$req->category];
        }
        if (@$req->status) {
            $where[] = ['status_id', @$req->status];
        }

        return $query->where($where);
    }
    // active course
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    // visible course
    public function scopeVisible($query)
    {
        return $query->where('visibility_id', 22);
    }

    // scope for discount course
    public function scopeDiscount($query)
    {
        return $query->where('is_discount', 11);
    }

    // Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    // course creator
    public function instructor(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
    // course creator
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    // relation with casted array
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    // all partner instructor
    public function partnerInstructors()
    {

        return DB::table('users')->whereIn('id', $this->partner_instructors ?? [])->select('id', 'name')->get();
    }

    // Section relation
    public function sections()
    {
        return $this->hasMany('Modules\Course\Entities\Section')->orderBy('order', 'asc');
    }

    // lesson relation
    public function lessons()
    {
        return $this->hasManyThrough('Modules\Course\Entities\Lesson', 'Modules\Course\Entities\Section', );
    }

    // all lesson relation
    public function allLessons()
    {
        return $this->hasMany('Modules\Course\Entities\Lesson');
    }

    public function firstLesson()
    {
        return $this->hasOne('Modules\Course\Entities\Lesson')->orderBy('order', 'asc');
    }

    // quizzes relationship
    public function quizzes()
    {
        return $this->hasManyThrough('Modules\Course\Entities\Lesson', 'Modules\Course\Entities\Section')->where('is_quiz', 1);
    }

    // thumbnail relation
    public function thumbnailImage()
    {
        return $this->belongsTo('App\Models\Upload', 'thumbnail');
    }

    // meta image relation
    public function metaImage()
    {
        return $this->belongsTo('App\Models\Upload', 'meta_image');
    }

    // course assignment relation
    public function assignments()
    {
        return $this->hasMany('Modules\Course\Entities\Assignment');
    }
    // course assignment relation
    public function activeAssignments()
    {
        return $this->hasMany('Modules\Course\Entities\Assignment')->where('status_id', 22);
    }

    // course NoticeBoard relation
    public function noticeBoards()
    {
        return $this->hasMany('Modules\Course\Entities\NoticeBoard');
    }

    // course Review relation
    public function reviews()
    {
        return $this->hasMany('Modules\Course\Entities\Review');
    }

    // course language relation
    public function lang()
    {
        return $this->belongsTo(Language::class, 'language', 'code');
    }

    // course language relation
    public function courseType()
    {
        return $this->belongsTo(Status::class, 'course_type');
    }

    // course scopeFilter
    public function scopeFilter($query, $req)
    {
        $where = [];

        if (@$req->instructor_id) {
            $where[] = ['created_by', '=', $req->instructor_id];
        }

        if (@$req->search && $req->search != 'undefined' && $req->search != 'null') {
            $where[] = ['title', 'like', '%' . $req->search . '%'];
        }

        if (@$req->category) {
            $where[] = ['course_category_id', '=', $req->category];
        }

        if (@$req->status) {
            $where[] = ['status_id', '=', $req->status];
        }

        if (isset($req->is_free) && !in_array($req->is_free, ['undefined', 'null', ''])) {
            $where[] = ['is_free', '=', $req->is_free];
        }
        // start filter for array value
        if (@$req->languages) {
            $query->whereIn('language', explode(',', $req->languages));
        }

        if (@$req->categories) {
            $query->whereIn('course_category_id', explode(',', $req->categories));
        }

        if (@$req->instructors) {
            $query->whereIn('created_by', explode(',', $req->instructors));
        }

        if (@$req->course_level) {
            $query->whereIn('level_id', explode(',', $req->course_level));
        }

        if (@$req->ratings) {
            $ratings = explode(',', $req->ratings);
            $query->where(function ($query) use ($ratings) {
                foreach ($ratings as $rating) {
                    $query->orWhere('rating', '>=', $rating)
                        ->where('rating', '<', $rating + 1);
                }
            });
        }
        if (@$req->sortTag == 'featured') {
            $query->whereIn('id', DB::table('featured_courses')->pluck('course_id')->toArray());
        }
        if (@$req->sortTag == 'discount') {
            $query->where('is_discount', 11)->where('discount_price', '>', 0);
        }
        if(@$req->package){
            $package_id = DB::table('packages')->where('slug', $req->package)->pluck('id');
            $query->whereIn('id', DB::table('package_courses')->where('package_id', $package_id)->pluck('course_id')->toArray());
        }
        return $query->where($where);
    }

    // course scopeSort
    public function scopeSort($query, $req)
    {
        switch ($req->sortTag) {
            case 'best_rated':
                $sort_by = 'rating';
                $sort_type = 'DESC';
                break;
            case 'popular':
                $sort_by = 'total_sales';
                $sort_type = 'DESC';
                break;
            case 'new':
                $sort_by = 'created_at';
                $sort_type = 'DESC';
                break;
            case 'highest_price':
                $sort_by = 'price';
                $sort_type = 'DESC';
                break;
            case 'lowest_price':
                $sort_by = 'price';
                $sort_type = 'ASC';
                break;
            case 'discount':
                $sort_by = 'discount_price';
                $sort_type = 'ASC';
                break;
            default:
                $sort_by = 'created_at';
                $sort_type = 'DESC';
                break;
        }
        return $query->orderBy($sort_by, $sort_type);
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

    public function withCourse()
    {
        return $this->with(['courseType:id,name,class', 'thumbnailImage:original', 'allLessons:course_id', 'user:id,role_id,name,image_id', 'firstLesson:id,course_id']);
    }

    public function scopeCourseByType($query, $req)
    {

        if (@$req->type == 'featured_courses') {
            return $query->whereIn('id', DB::table('featured_courses')->pluck('course_id')->toArray());
        }
        if (@$req->type == 'latest_courses') {
            return $query->orderBy('id', 'desc');
        }
        if (@$req->type == 'best_rated_courses') {
            return $query->where('rating', '>', 0)->orderBy('rating', 'desc');
        }
        if (@$req->type == 'best_selling_courses') {
            return $query->where('total_sales', '>', 0)->orderBy('total_sales', 'desc');
        }
        if (@$req->type == 'free_courses') {
            return $query->where('is_free', '=', 1);
        }
        if (@$req->type == 'discount_courses') {
            return $query->where('is_discount', '=', 11);
        }
    }

    public function scopeCourseByPackage($query, $req)
    {
        return $query->whereIn('id', $req);
    }
}
