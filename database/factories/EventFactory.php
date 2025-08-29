<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(3);
        return [
            'title' => $title,
            'slug'  => \Illuminate\Support\Str::slug($title.'-'.fake()->unique()->numerify('###')),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['budaya','olahraga','religi','komunitas']),
            'location' => fake()->city(),
            'starts_at' => now()->addDays(fake()->numberBetween(1,20))->setTime(fake()->numberBetween(8,20), 0),
            'ends_at' => null,
            'contact_whatsapp' => '62812'.fake()->numerify('#######'),
            'is_published' => true,
        ];
    }
}
