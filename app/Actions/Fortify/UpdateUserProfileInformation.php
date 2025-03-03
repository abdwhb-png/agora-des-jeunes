<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Enums\AccountActivityEnum;
use App\Services\AccountActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
            AccountActivityLogger::log(AccountActivityEnum::PROFILE_PIC_UPDATED, ['email' => $user->email]);
        }

        if (!empty($input['email'])) {
            if (
                $input['email'] !== $user->email &&
                $user instanceof MustVerifyEmail
            ) {
                $this->updateVerifiedUser($user, $input);
            } else {
                $user->forceFill([
                    'email' => $input['email'],
                ])->save();
            }

            AccountActivityLogger::log(AccountActivityEnum::EMAIL_UPDATED, ['email' => $user->email]);
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
