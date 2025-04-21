<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CMS\Database\Seeders\CMSSeeder;
use Modules\CMS\Database\Seeders\FeaturedCourseSeeder;

class CMSDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CMSSeeder::class);
        $this->call(FeaturedCourseSeeder::class);
    }
}
