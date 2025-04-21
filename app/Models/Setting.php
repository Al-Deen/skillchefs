<?php

namespace App\Models;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['name','value'];

    // booted
    protected static function booted()
    {



        static::created(function ($settings) { // when courses created then forget cache
            cache()->forget('setting');
            cache()->forget('light_logo');
            cache()->forget('half_light_logo');
            cache()->forget('dark_logo');
            cache()->forget('half_dark_logo');
            cache()->forget('currency_symbol');
            cache()->forget('app_base_settings');
        });
        
        static::saved(function ($settings) { // when courses created then forget cache
            cache()->forget('setting');
            cache()->forget('light_logo');
            cache()->forget('half_light_logo');
            cache()->forget('dark_logo');
            cache()->forget('half_dark_logo');
            cache()->forget('currency_symbol');
            cache()->forget('app_base_settings');
        });

        static::updated(function ($settings) { // when courses updated then forget cache
            cache()->forget('setting');
            cache()->forget('light_logo');
            cache()->forget('half_light_logo');
            cache()->forget('dark_logo');
            cache()->forget('half_dark_logo');
            cache()->forget('currency_symbol');
            cache()->forget('app_base_settings');
        });
    }

    public function lightLogo()
    {
        return $this->belongsTo(Upload::class, 'light_logo', 'id');
    }

    public function darkLogo()
    {
        return $this->belongsTo(Upload::class, 'dark_logo', 'id');
    }

    public function favicon()
    {
        return $this->belongsTo(Upload::class, 'favicon', 'id');
    }

}
