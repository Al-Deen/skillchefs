<?php

namespace Modules\Order\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\AssignmentSubmit;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Lesson;
use Modules\Course\Entities\QuizResult;
use Modules\Order\Entities\Note;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;

class Enroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'course_id',
        'user_id',
        'progress',
        'is_completed',
        'completed_lessons',
        'completed_quizzes',
        'lesson_point',
        'quiz_point',
        'assignment_point',
        'completed_assignments',
        'completed_at',
        'visited',
        'total_sales',
    ];

    protected $casts = [
        'completed_lessons' => 'array',
        'completed_quizzes' => 'array',
        'completed_assignments' => 'array',
    ];

    // relation with order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // relation with course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // user relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // lesson relation
    public function lessons()
    {
        // table enrols: course_id and table lessons: course_id how to make relation
        return $this->hasMany(Lesson::class, 'course_id', 'course_id');
    }

    // quiz result relation
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function announcements($query)
    {
        return $query->course->noticeBoards->map(function ($item) {
            $item->created_at = date('d M Y', strtotime($item->created_at));
            $item->description = strip_tags($item->description);
            return $item;
        })->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'created_at' => $item->created_at,
            ];
        });
    }

    // relation with Note
    public function notes()
    {
        return $this->hasMany(Note::class)->orderBy('id', 'desc');
    }

    // search
    public function scopeSearch($query, $req)
    {
        if (@$req->search) {
            return $query->whereHas('course', function ($query) use ($req) {
                $query->where('title', 'like', '%' . @$req->search . '%')->orWhereHas('instructor', function ($query) use ($req) {
                    $query->where('name', 'like', '%' . @$req->search . '%');
                });
            });
        }
    }

    public function assignmentSubmits()
    {
        return $this->hasMany(AssignmentSubmit::class);
    }

    // relation with order item
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function completed($query)
    {

        $query->user->student->update([
            'points' => $query->user->student->points + $query->lesson_point + $query->quiz_point + $query->assignment_point,
        ]);
        $query->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
        return $query;
    }

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', 1);
    }

    public function lastVisited($query)
    {
        return $query->orderBy('visited', 'desc')->first();
    }

    public function total_student()
    {
        return $this->where('course_id', $this->course_id)->count();
    }
}
