<?php

namespace App\Observers;

use App\Models\User;
use App\Enums\RolesEnum;
use App\Models\UserInfo;
use App\Models\UserAccount;
use App\Enums\AccountActivityEnum;
use App\Services\AccountActivityLogger;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        UserInfo::updateOrCreate(
            ['user_id' => $user->id],
            []
        );

        UserAccount::updateOrCreate(
            ['user_id' => $user->id],
            []
        );

        $user->assignRole(RolesEnum::USER->value);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $metaData = ['email' => $user->email];
        if ($user->wasChanged('profile_photo_path')) {
            AccountActivityLogger::log(AccountActivityEnum::PROFILE_PIC_UPDATED, $user, $metaData);
        }

        if ($user->wasChanged('email')) {
            AccountActivityLogger::log(AccountActivityEnum::EMAIL_UPDATED, $user, $metaData);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
