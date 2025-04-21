<?php

namespace Modules\Event\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Database\Seeders\EventPermissionTableSeeder;
use Modules\Event\Database\Seeders\EventCategoryTableSeeder;

class EventDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EventPermissionTableSeeder::class,
            EventCategoryTableSeeder::class,
        ]);
    }
}
