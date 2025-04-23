<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Enums\RolesEnum;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Mail\Invitation as InvitationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UsersController extends BaseController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:' . RolesEnum::ROOT->value, only: ['updateRoles', 'updatePermissions']),
        ];
    }

    public function index()
    {
        return UserResource::collection(User::role(RolesEnum::USER->value)->get());
    }

    public function managers()
    {
        return UserResource::collection(User::role(RolesEnum::MANAGER->value)->get());
    }

    public function updateRoles(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user->syncRoles($validated['roles']);
    }

    public function updatePermissions(Request $request, User $user)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $user->syncPermissions($validated['permissions']);
    }

    public function joiningInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:30',
            'role' => 'required|string|in:user,admin',
        ]);

        if (User::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Un utilisateur avec cette adresse email existe deja !',
            ]);
        }

        DB::transaction(function () use ($request) {
            $token = Str::random(32);
            $invitation = Invitation::updateOrCreate(
                [
                    'email' => $request->email,
                    'created_by' => Auth::id(),
                ],
                [
                    'name' => $request->name,
                    'token' => $token,
                    'link' => $request->role == 'user' ? reg_url($token) : null,
                    'expires_at' => now()->addHours(3),
                ]
            );

            // Envoyer un email d'invitation
            Mail::to($request->email)->send(new InvitationMail($request->user(), $invitation, $request->only('name')));

            // Enregistrer l'activité
            activity()
                ->withProperties(['ip_address' => $request->ip()])
                ->event('invitation_sent')
                ->log('Invitation envoyée par ' . $request->user()->email);
        });

        return back(303)->with('success', 'Invitation envoyée avec succès.');
    }
}
