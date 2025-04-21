<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Database\Seeders\CourseTableSeeder;
use Modules\Course\Database\Seeders\CourseCategoryTableSeeder;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(CourseTableSeeder::class);
    }
}
