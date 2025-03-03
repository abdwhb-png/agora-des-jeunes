<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollOptionFactory extends Factory
{
    protected $model = PollOption::class;

    public function definition(): array
    {
        return [
            'poll_id' => Poll::factory(), // Crée un sondage si nécessaire
            'option_text' => $this->faker->sentence(3),
        ];
    }
}
