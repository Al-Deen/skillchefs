<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'icon_class' => 'flag-icon flag-icon-us',
            'direction'=>'ltr'
        ]);
        Language::create([
            'name' => 'Arabic',
            'code' => 'ar',
            'icon_class' => 'flag-icon flag-icon-sa',
            'direction'=>'rtl'
        ]);
        Language::create([
            'name' => 'Turkish',
            'code' => 'tr',
            'icon_class' => 'flag-icon flag-icon-tr',
            'direction'=>'ltr'
        ]);
        Language::create([
            'name' => 'Russian',
            'code' => 'ru',
            'icon_class' => 'flag-icon flag-icon-ru',
            'direction'=>'ltr'
        ]);
    }
}
