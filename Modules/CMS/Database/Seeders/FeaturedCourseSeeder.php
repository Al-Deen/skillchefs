<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Session;
use Modules\CMS\Entities\FeaturedCourse;

class FeaturedCourseSeeder extends Seeder
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
                    'course_id' => 1,
                    'status_id' => 1,
                ],
                [
                    'course_id' => 2,
                    'status_id' => 1,
                ],
                [
                    'course_id' => 3,
                    'status_id' => 1,
                ],
                [
                    'course_id' => 4,
                    'status_id' => 1,
                ],

            ];

            foreach ($data as $key => $value) {
                \Modules\CMS\Entities\FeaturedCourse::create($value);
            }
        }

    }
}
