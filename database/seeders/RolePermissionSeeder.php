<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $basePermsOne = [
            PermissionsEnum::VIEW_DASHBOARD->value,
            PermissionsEnum::INVITE_USER->value,
        ];

        $basePermsTwo = [
            PermissionsEnum::VIEW_USERS->value,
            PermissionsEnum::MANAGE_AGORA_SESSIONS->value,
            PermissionsEnum::MANAGE_POLLS->value,
            PermissionsEnum::MANAGE_FAQS->value,
            PermissionsEnum::MANAGE_SCHOLARSHIPS->value,
            PermissionsEnum::MANAGE_TENDERS->value,
            PermissionsEnum::MANAGE_DEPARTEMENTS->value,
        ];

        $basePermsThree = [
            PermissionsEnum::MANAGE_TRAININGS->value,
            PermissionsEnum::MANAGE_JOB_OFFERS->value,

            PermissionsEnum::CREATE_USER->value,
            PermissionsEnum::EDIT_USER->value,
            PermissionsEnum::DELETE_USER->value,

            PermissionsEnum::VIEW_MANAGERS->value,
            PermissionsEnum::CREATE_MANAGER->value,
            PermissionsEnum::EDIT_MANAGER->value,
            PermissionsEnum::DELETE_MANAGER->value,
        ];

        // Créer toutes les permissions
        foreach (PermissionsEnum::all() as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        };

        // Assigner les permissions aux rôles
        $rolesPermissions = [
            RolesEnum::USER->value => [
                ...$basePermsOne,
            ],

            RolesEnum::MANAGER->value => [
                ...$basePermsOne,
                ...$basePermsTwo,
            ],

            RolesEnum::ADMIN->value => [
                ...$basePermsOne,
                ...$basePermsTwo,
                ...$basePermsThree,
            ],

            RolesEnum::SUPERADMIN->value => [
                ...$basePermsOne,
                ...$basePermsTwo,
                ...$basePermsThree,

                PermissionsEnum::VIEW_ADMINS->value,
                PermissionsEnum::CREATE_ADMIN->value,
                PermissionsEnum::EDIT_ADMIN->value,
                PermissionsEnum::DELETE_ADMIN->value,

                PermissionsEnum::VIEW_ROLES->value,
                PermissionsEnum::VIEW_PERMISSIONS->value,

                PermissionsEnum::MANAGE_CONFIGURATION->value,
            ],

            RolesEnum::ROOT->value => PermissionsEnum::all(), // Root a toutes les permissions
        ];

        // Créer les rôles et assigner les permissions
        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
