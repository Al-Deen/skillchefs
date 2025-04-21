<?php

namespace Modules\Event\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventScheduleListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Event\Entities\EventScheduleList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'from_time' => $this->faker->dateTimeBetween('now', '+1 years'),
            'to_time' => $this->faker->dateTimeBetween('now', '+1 years'),
            'location' => $this->faker->address,
            'details' => $this->faker->paragraph(4),
            'status_id' => 1,
            'event_schedule_id' => rand(1, 60),
            'created_by' => 5,
        ];
    }
}
