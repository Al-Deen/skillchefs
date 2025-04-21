<?php

namespace Modules\Event\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Event\Entities\Event;
use Modules\Event\Entities\EventCategory;
use Modules\Event\Entities\EventOrganizer;
use Modules\Event\Entities\EventSchedule;
use Modules\Event\Entities\EventScheduleList;
use Modules\Event\Entities\EventSpeaker;

class EventCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (@Session()->get('temp_data') || env('APP_TEST')) {
            try {
                $categories = [
                    "Web Development",
                    "Web Design",
                    "App Development",
                    "App Design",
                    "UI/UX",
                    "Career",
                    "Lifestyle",
                ];

                $categoriesArray = [];
                foreach ($categories as $category) {
                    $categoriesArray[] = [
                        'title' => $category,
                        'slug' => Str::slug($category),
                        'created_by' => 1,
                        'status_id' => 1,
                        'created_at' => now(),
                    ];
                }
                EventCategory::insert($categoriesArray);

                Event::factory()->count(30)->create();
                EventOrganizer::factory()->count(30)->create();
                EventSpeaker::factory()->count(30)->create();
                EventSchedule::factory()->count(60)->create();
                EventScheduleList::factory()->count(60)->create();
            } catch (\Exception $e) {
                dd($e);
            }
        }

    }
}
