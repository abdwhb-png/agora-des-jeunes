<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone' => ['required', 'string', 'max:255'],
            'nom' => ['sometimes', 'string', 'max:255'],
            'prenom' => ['sometimes', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if (isset($input['nom']) && isset($input['prenom'])) {
            $user->info->updateOrCreate([
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
            ]);
        }

        // Marquer l'invitation comme utilisée
        if (isset($input['invitation_id'])) {
            $invitation = \App\Models\Invitation::find($input['invitation_id']);
            $invitation->update(['is_used' => true]);
        }

        $user->sendWelcomeEmail();

        Session::flash('success', 'just-registered');

        return $user;
    }
}
