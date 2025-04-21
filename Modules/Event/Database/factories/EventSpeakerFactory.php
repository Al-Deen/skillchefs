<?php

namespace Modules\Event\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventSpeakerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Event\Entities\EventSpeaker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'designation' => $this->faker->jobTitle,
            'event_id' => $this->faker->numberBetween(1, 30),
            'status_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
