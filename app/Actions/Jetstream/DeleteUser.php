<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\AccountActivityEnum;
use App\Services\AccountActivityLogger;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user, Request $request): void
    {
        $request->validate([
            'action' => 'string|in:delete,deactivate'
        ]);

        if ($request->action == 'deactivate') {
            $user->update(['status' => false]);

            AccountActivityLogger::log(AccountActivityEnum::ACCOUNT_DEACTIVATED, ['email' => $user->email]);
        }

        // $user->deleteProfilePhoto();
        // $user->tokens->each->delete();
        // $user->delete();
    }
}
