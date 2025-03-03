<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->withRole(RolesEnum::ROOT->value)->create([
            'email' => 'salifouabdwhb@gmail.com',
        ]);

        User::factory()->withRole(RolesEnum::SUPERADMIN->value)->create([
            'email' => 'superadmin@example.com',
        ]);

        User::factory()->withRole(RolesEnum::ADMIN->value)->create([
            'email' => 'admin@example.com',
        ]);


        User::factory(rand(10, 30))->withInfo()->create();
    }
}