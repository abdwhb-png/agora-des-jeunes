<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Setting;
use App\Models\UserInfo;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UsersCollection;
use App\Http\Controllers\Base\AdminController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class GestionController extends AdminController
{
    public function dashboard()
    {
        $neighboursStats = [
            'count' => UserInfo::whereNotNull('quartier')->count(),
            'top' => $this->topNeighbours(),
        ];

        return Inertia::render(page_dir() . 'Dashboard', [
            'stats' => $this->dashStats(),
            'users_stats' => request()->user()->isAdmin() ? $this->userStats() : [],
            'roles_stats' => request()->user()->can(PermissionsEnum::VIEW_ROLES->value) ? $this->rolesStats() : [],
            'neighbours_stats' => $neighboursStats,

            'agora_sessions' => $this->paginatedAgoraSessions(),
            'polls' =>  $this->paginatedPolls(),
            'faqs' => $this->paginatedFaqs(),

            'can' => [
                'managePolls' => request()->user()->can(PermissionsEnum::MANAGE_POLLS->value),
                'manageAgoraSessions' => request()->user()->can(PermissionsEnum::MANAGE_AGORA_SESSIONS->value),
                'manageFaqs' => request()->user()->can(PermissionsEnum::MANAGE_FAQS->value),
            ]
        ]);
    }

    public function users()
    {
        $filterName = 'users';
        $search = $this->getFilter($filterName, 'search');
        $users = new UsersCollection(
            User::list()
                ->search($search)
                ->latest()->paginate(
                    perPage: $this->getFilter($filterName, 'per_page', 20),
                    pageName: $filterName
                )
        );

        return Inertia::render(page_dir() . 'Users', [
            'users' => $users->toArray(request()),
            'users_invitations' => $this->getInvitations(),
            'can' => [
                'createUser' => request()->user()->can(PermissionsEnum::CREATE_USER->value),
                'editUser' => request()->user()->can(PermissionsEnum::EDIT_USER->value),
                'viewUsers' => request()->user()->can(PermissionsEnum::VIEW_USERS->value),
                'seeRoles' => request()->user()->can(PermissionsEnum::VIEW_ROLES->value),
                'seePerms' => request()->user()->can(PermissionsEnum::VIEW_PERMISSIONS->value),
            ]
        ]);
    }

    public function configuration()
    {
        $canManageConfig = request()->user()->can(PermissionsEnum::MANAGE_CONFIGURATION->value);

        return Inertia::render(page_dir() . 'Configuration', [
            'site_settings' => $canManageConfig ?  settings()->toArray() : [],
            'social_links' => $canManageConfig ? social_links() : [],
            'job_offers' => $this->paginatedJobOffers(),
            'trainings' => $this->paginatedTrainings(),
            'departements' => Inertia::defer(fn() => $this->getDepartements()),

            'can' => [
                'manageTrainings' => request()->user()->can(PermissionsEnum::MANAGE_TRAININGS->value),
                'manageJobOffers' => request()->user()->can(PermissionsEnum::MANAGE_JOB_OFFERS->value),
                'manageDepartements' => request()->user()->can(PermissionsEnum::MANAGE_DEPARTEMENTS->value),
                'manageConfig' => $canManageConfig,
            ],
        ]);
    }

    public function updateSetting(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'site_name' => 'required|string',
            'site_description' => 'required|string|max:255',
            'site_keywords' => 'nullable|string',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'site_address' => 'nullable|string',
            'help_availability' => 'nullable|string',
            'tcs_url' => 'nullable|url:http,https',
        ]);

        $setting->update($validated);

        return back(303)->with('success', 'Réglages du site mis à jour avec succès.');
    }

    public function updateSocialLink(Request $request, SocialLink $item)
    {
        $validated = $request->validate([
            'platform' => [
                'required',
                'string',
                'max:255',
                Rule::unique('social_links', 'platform')->ignore($item->id),
            ],
            'url' => 'nullable|url:http,https',
            'logo' => 'nullable|url:http,https',
        ]);

        $item->update($validated);

        return back(303)->with('status', 'Lien de réseau social mis à jour avec succès.');
    }

    public function logoutEveryone()
    {
        DB::table('sessions')->whereNotNull('user_id')
            ->where('user_id', '!=', request()->user()->id)->delete();

        return back(303)->with('success', 'Tout le monde est maintenant déconnecté.');
    }

    public function resetAllSessions()
    {
        DB::table('sessions')->truncate();

        return back(303)->with('success', 'Toutes les sessions sont maintenant supprimées.');
    }
}
