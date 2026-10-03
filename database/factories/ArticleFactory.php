<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_id'        => Source::factory(),
            'url'              => $this->faker->unique()->url(),
            'title'            => $this->faker->sentence(),
            'original_title'   => $this->faker->sentence(),
            'description'      => $this->faker->paragraph(),
            'language'         => $this->faker->randomElement(['en', 'ar', 'fr']),
            'country_code'     => $this->faker->countryCode(),
            'published_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
            'status'           => 'raw',
            'is_duplicate'     => false,
            'importance_score' => $this->faker->numberBetween(0, 100),
            'content_hash'     => $this->faker->sha256(),
        ];
    }

    public function processed(): static
    {
        return $this->state(['status' => 'processed']);
    }

    public function duplicate(): static
    {
        return $this->state(['is_duplicate' => true]);
    }
}