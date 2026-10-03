<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'                   => $this->faker->company(),
            'slug'                   => $this->faker->unique()->slug(),
            'website_url'            => $this->faker->url(),
            'feed_url'               => $this->faker->url(),
            'feed_type'              => 'rss',
            'country_code'           => $this->faker->countryCode(),
            'language'               => $this->faker->randomElement(['en', 'ar', 'fr']),
            'bias'                   => $this->faker->randomElement(['center', 'center-left', 'center-right']),
            'type'                   => $this->faker->randomElement(['newspaper', 'tv_channel', 'digital']),
            'reliability_score'      => $this->faker->numberBetween(50, 90),
            'is_active'              => true,
            'is_free'                => true,
            'fetch_interval_minutes' => 15,
        ];
    }
}