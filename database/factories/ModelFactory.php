<?php

namespace Sfolador\Support\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sfolador\Support\Models\SupportRequest;

class SupportRequestFactory extends Factory
{
    protected $model = SupportRequest::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'support_type' => $this->faker->randomElement(['issue', 'email', 'data_removal', 'inquiry']),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
