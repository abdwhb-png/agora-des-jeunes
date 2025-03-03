<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\RolesEnum;
use App\Models\Invitation;
use App\Traits\HasSessions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Enums\AccountActivityEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\AccountActivityLogger;
use App\Mail\Invitation as InvitationMail;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends BaseController implements HasMiddleware
{
    use HasSessions;

    public static function middleware(): array
    {
        return [
            new Middleware('role:' . RolesEnum::ROOT->value, only: ['updateRoles']),
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

    public function me()
    {
        return new UserResource(request()->user());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function updateInfo(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|string',
            'prenom' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'sexe' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'ville' => 'sometimes|string',
            'quartier' => 'sometimes|string',
            'departement' => 'nullable|string',
            'arrondissement' => 'nullable|string',
        ]);

        $user->info()->update($request->except('phone'));

        if ($request->phone) {
            $user->update(['phone' => $request->phone]);
        }

        AccountActivityLogger::log(AccountActivityEnum::PROFILE_UPDATED, ['email' => $user->email]);

        return back(303)->with('success', 'Informations mis à jour avec succès.');
    }

    public function updateAccount(Request $request, User $user)
    {
        $validated = $request->validate([
            'allow_tracking' => 'sometimes|boolean',
            'two_step_verification' => 'sometimes|boolean',
        ]);

        $user->account()->update($validated);

        return back(303)->with('success', 'Informations mis à jour avec succès.');
    }

    public function invite(Request $request)
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

    public function sessions(): JsonResponse
    {
        return response()->json($this->getSessions(request())->all());
    }


    public function permissions(): JsonResponse
    {
        return response()->json([
            'via_roles' => request()->user()->getPermissionsViaRoles()->each->load('roles'),
            'direct' => request()->user()->getDirectPermissions()->each->load('roles'),
            'all' => request()->user()->getAllPermissions()->each->load('roles'),
        ]);
    }

    public function roles(): JsonResponse
    {
        return response()->json(request()->user()->roles);
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
}
