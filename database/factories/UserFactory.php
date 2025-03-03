<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\Models\Commune;
use App\Models\UserInfo;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn(array $attributes, User $user) => [
                    'name' => $user->email . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    public function withRole($role)
    {
        return $this->afterCreating(function (User $user) use ($role) {
            $user->assignRole($role);
        });
    }

    public function withInfo()
    {
        return $this->afterCreating(function (User $user) {
            $commune = Commune::whereNotNull('quartiers')->inRandomOrder()->first();

            UserInfo::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nom' => fake()->lastName(),
                    'prenom' => fake()->firstName(),
                    'sexe' => fake()->randomElement(['M', 'F']),
                    'date_naissance' => fake()->date(),
                    'ville' => $commune->name,
                    'arrondissement' => $commune->arrondissements()->inRandomOrder()->first()->name,
                    'quartier' => count($commune->quartiers) > 0 ? $commune->quartiers[random_int(0, count($commune->quartiers) - 1)] : (rand(0, 1) ? null : 'Par défaut'),
                ]
            );
        });
    }
}