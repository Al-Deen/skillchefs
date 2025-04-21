<?php

namespace App\Models;

use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
