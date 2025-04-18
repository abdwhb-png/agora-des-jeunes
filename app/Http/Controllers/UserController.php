<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Enums\RolesEnum;
use App\Traits\HasSessions;
use Illuminate\Http\Request;
use App\Helpers\ConfigHelper;
use Laravel\Fortify\Features;
use Illuminate\Http\JsonResponse;
use App\Enums\AccountActivityEnum;
use App\Http\Resources\UserResource;
use App\Services\AccountActivityLogger;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Routing\Controllers\Middleware;
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
            'sexe' => 'nullable|string|in:' . implode(',', ConfigHelper::getGenders()),
            'date_naissance' => 'nullable|date',
            'quartier' => 'sometimes|string',
            'ville' => 'nullable|string',
            'departement' => 'nullable|string',
            'arrondissement' => 'nullable|string',
            'interests' => 'nullable|array',
        ]);

        $user->info()->update($request->except('phone', 'interests'));

        if ($request->phone) {
            $user->update(['phone' => $request->phone]);
        }

        if ($request->interests) {
            $user->account()->update(['interests' => $request->interests]);
        }

        AccountActivityLogger::log(AccountActivityEnum::PROFILE_UPDATED, $user, ['email' => $user->email]);

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

    public function settings(): Response
    {
        $search = $this->getFilter('account_activities', 'search');
        return Inertia::render('Settings/Index', [
            'account_activities' => request()->user()->activities()
                ->where('event', 'like', '%' . $search . '%')
                ->latest()->paginate($this->perPage($this->getFilter('account_activities', 'per_page', 20))),
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
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

    public function updatePermissions(Request $request, User $user)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $user->syncPermissions($validated['permissions']);
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
}
