<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Setting::create([
            'site_email' => 'contact@' . env('SITE_DOMAIN', 'example.com'),
            'site_phone' => '+229 01 96 00 00 00',
            'site_slogan' => 'Le lieu où l\'avenir prend forme.',
            'help_availability' => 'Dispo du Lundi au Vendredi, 9h00 à 18h00',
        ]);

        \App\Models\SocialLink::factory(4)->create();

        $this->call([
            RolePermissionSeeder::class,
            DepartementSeeder::class,
            UserSeeder::class,
            FeatureSeeder::class,
            FaqSeeder::class,
        ]);

        \App\Models\Poll::factory(7)->create();
        \App\Models\PollVote::factory(100)->create();
    }
}
