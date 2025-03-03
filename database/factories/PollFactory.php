<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollFactory extends Factory
{
    protected $model = Poll::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'is_public' => $this->faker->boolean(80), // 80% de chances d'être actif
            'start_at' => now()->subDays(rand(1, 5)), // Dernier 5 jours
            'end_at' => now()->addDays(rand(1, 30)), // Expire entre 1 et 30 jours
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Poll $poll) {
            // Générer 3 à 5 options pour ce sondage
            $options = PollOption::factory(rand(3, 5))->create(['poll_id' => $poll->id]);

            // Générer 10 à 30 votes
            PollResult::factory(rand(10, 10))->create([
                'poll_id' => $poll->id,
                'poll_option_id' => $options->random()->id, // Vote aléatoire
            ]);
        });
    }
}
