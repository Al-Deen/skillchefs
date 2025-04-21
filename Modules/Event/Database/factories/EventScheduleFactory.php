<?php

namespace Modules\Event\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Event\Entities\EventSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => 1,
            'title' => $this->faker->sentence(2),
            'date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'event_id' => rand(1, 30),
            'status_id' => 1,
            'created_by' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
