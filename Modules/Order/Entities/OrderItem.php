<?php

namespace Modules\Order\Entities;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [];

    // relation with course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // relation with order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
