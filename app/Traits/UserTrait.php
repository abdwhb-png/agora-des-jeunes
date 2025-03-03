<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Social;
use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait UserTrait
{
    public function sendWelcomeEmail(): void
    {
        if ($this->email) {
            Mail::to($this->email)->send(new \App\Mail\Welcome($this));
        }
    }

    public function createSocial($socialUser, $provider): Social
    {
        return $this->socials()->create([
            'provider_id' => $socialUser->getId(),
            'provider' => $provider,
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole([RolesEnum::ADMIN->value, RolesEnum::SUPERADMIN->value, RolesEnum::ROOT->value]);
    }

    public function isRoot(): bool
    {
        return $this->hasRole([RolesEnum::ROOT->value]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->orWhereHas('info', function ($query) use ($search) {
                $query->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenom', 'like', '%' . $search . '%');
            });
    }

    public function scopeList($query)
    {
        return $query->when(Auth::check(), function ($query) {
            $user = User::find(Auth::id());
            $roles = [RolesEnum::USER->value]; // Par défaut, on filtre les utilisateurs

            if ($user->hasPermissionTo(PermissionsEnum::VIEW_MANAGERS->value)) {
                $roles[] = RolesEnum::MANAGER->value;
            }
            if ($user->hasPermissionTo(PermissionsEnum::VIEW_ADMINS->value)) {
                $roles[] = RolesEnum::ADMIN->value;
            }
            if ($user->hasPermissionTo(PermissionsEnum::VIEW_SUPERADMINS->value)) {
                $roles[] = RolesEnum::SUPERADMIN->value;
            }

            $query->where('id', '!=', Auth::id())->role($roles);
        });
    }

    public function scopeManagers($query)
    {
        return $query->role([RolesEnum::MANAGER->value]);
    }

    public function scopeAdmins($query)
    {
        return $query->role([RolesEnum::ADMIN->value, RolesEnum::SUPERADMIN->value, RolesEnum::ROOT->value]);
    }

    public function scopeSuperAdmins($query)
    {
        return $query->role([RolesEnum::SUPERADMIN->value, RolesEnum::ROOT->value]);
    }

    public function scopeOnlyUsers($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', RolesEnum::USER->value);
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', '!=', RolesEnum::USER->value);
        });
    }
}
