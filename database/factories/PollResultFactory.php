<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollResultFactory extends Factory
{
    protected $model = PollResult::class;

    public function definition(): array
    {
        // Sélectionner un sondage existant
        $poll = Poll::inRandomOrder()->first();

        // Sélectionner une option de sondage existante pour le sondage sélectionné
        $pollOption = $poll ? PollOption::where('poll_id', $poll->id)->inRandomOrder()->first() : null;

        return [
            'poll_id' => $poll ? $poll->id : Poll::factory(), // Créer un nouveau sondage si aucun n'est trouvé
            'poll_option_id' => $pollOption ? $pollOption->id : PollOption::factory(), // Créer une nouvelle option si aucune n'est trouvée
            'votes' => $this->faker->numberBetween(0, 100), // Nombre de votes aléatoire
        ];
    }
}
