<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (@Session()->get('temp_data') || env('APP_TEST')) {

            $data = [
                [
                    // 1
                    'title' => 'Make yourself one',
                    'sub_title' => 'Comfort & Professional',
                    'description' => '<p>comprehensive educational experiences that develop and enhance skill sets that can be applied to diverse job profiles.</p>',
                    'serial' => '1',
                    'button_text' => 'Find your desired Course',
                    'button_url' => '#',
                    'image_id' => '5',
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    // 2
                    'title' => 'Make yourself two',
                    'sub_title' => 'Comfort & Professional',
                    'description' => '<p>comprehensive educational experiences that develop and enhance skill sets that can be applied to diverse job profiles.</p>',
                    'serial' => '2',
                    'button_text' => 'Find your desired Course',
                    'button_url' => '#',
                    'image_id' => '6',
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ];

            DB::table('sliders')->insert($data);
        }
    }
}
