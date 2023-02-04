<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'published_at' => $this->faker->dateTime,
            'link' => $this->faker->url,
            'city' => $this->faker->city,
            'district' => $this->faker->city,
            'street' => $this->faker->streetName . ' ' . $this->faker->buildingNumber,
            'rooms' => $this->faker->numberBetween(1, 5),
            'floor' => $this->faker->numberBetween(1, 10) . '/' . $this->faker->numberBetween(1, 10),
            'm2' => $this->faker->numberBetween(30, 100),
            'price' => $this->faker->randomFloat(2, 100, 800),
            'price_per_m2' => $this->faker->randomFloat(2, 4, 15),
            'series' => $this->faker->numberBetween(1, 10),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
