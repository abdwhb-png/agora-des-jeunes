<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\User;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PollVote>
 */
class PollVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Sélectionner un sondage existant
        $poll = Poll::inRandomOrder()->first();

        // Sélectionner une option de sondage existante pour le sondage sélectionné
        $pollOption = $poll ? $poll->options()->inRandomOrder()->first() : null;

        $user = rand(0, 100) <= 70 ? User::inRandomOrder()->first() : null;

        return [
            'poll_id' => $poll ? $poll->id : Poll::factory(), // Créer un nouveau sondage si aucun n'est trouvé
            'poll_option_id' => $pollOption ? $pollOption->id : PollOption::factory(), // Créer une nouvelle option si aucune n'est trouvée
            'user_id' => $user,
            'ip_address' => $user ? null : fake()->ipv4(),
        ];
    }
}
