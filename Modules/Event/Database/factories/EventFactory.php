<?php

namespace Modules\Event\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Event\Entities\Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tag = [
            ['value' => 'tag1'],
            ['value' => 'tag2'],
            ['value' => 'tag3'],
        ];
        return [
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph(4),
            'category_id' => $this->faker->numberBetween(1, 7),
            'event_type' => "Online",
            'start' => $this->faker->dateTimeBetween('now', '+1 years'),
            'end' => $this->faker->dateTimeBetween('now', '+1 years'),
            'registration_deadline' => $this->faker->dateTimeBetween('now', '+1 years'),
            'max_participant' => $this->faker->numberBetween(10, 100),
            'show_participant' => 22,
            'is_paid' => 11,
            'tags' => json_encode($tag),
            'price' => $this->faker->randomFloat(2, 50, 300),
            'status_id' => 4,
            'created_by' => 5,
            'address' => $this->faker->address,
            'online_note' => $this->faker->paragraph(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
