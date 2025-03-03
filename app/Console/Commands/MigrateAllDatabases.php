<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAllDatabases extends Command
{
    protected $signature = 'migrate:all';
    protected $description = 'Run migrate:fresh --seed for all databases';

    public function handle()
    {
        // Connexion principale
        $this->info('Migrating primary database...');
        $this->call('migrate:fresh', ['--seed' => true]);

        // Seconde connexion (définie dans config/database.php)
        $this->info('Migrating pulse database...');
        $this->call('migrate:fresh', ['--database' => env('PULSE_DB_CONNECTION', 'pulse'), '--force' => true]);


        $this->info('All databases migrated and seeded successfully.');
    }
}