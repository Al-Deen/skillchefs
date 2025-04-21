<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    //booted method
    protected static function booted()
    {

        static::created(function ($languages) { // when languages created then forget cache
            cache()->forget('languages');
        });

        static::saved(function ($languages) { // when languages created then forget cache
            cache()->forget('languages');
        });

        static::updated(function ($languages) { // when languages updated then forget cache
            cache()->forget('languages');
        });

        static::deleted(function ($languages) { // when languages deleted then forget cache
            cache()->forget('languages');
        });
    }
}
