<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Instructor\Entities\Instructor;

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


    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
