<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbassadorSetting extends Model
{
    use HasFactory;
    public $table = 'ambassador_settings';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'title', 'description'
    ];

    protected $casts = [
        'point_title' => 'array',
        'point_description' => 'array',
        'questions' => 'array',
    ];
}
