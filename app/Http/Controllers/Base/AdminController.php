<?php

namespace App\Http\Controllers\Base;

use App\Models\FAQ;
use App\Models\Poll;
use App\Models\User;
use App\Models\Commune;
use App\Enums\RolesEnum;
use App\Models\PollVote;
use App\Models\UserInfo;
use App\Models\Invitation;
use App\Models\Departement;
use App\Models\AgoraSession;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use App\Models\Arrondissement;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PollCollection;
use App\Http\Resources\AgoraSessionCollection;

class AdminController extends BaseController
{
    public function parsedUser(User $user)
    {
        return [
            'id' => $user->id,
            'full_name' => $user->info->full_name,
            'email' => $user->email,
            'profile_photo_url' => $user->profile_photo_url,
            'base' => [
                'tel' => $user->phone ?? '--',
                'nom' => $user->info->nom ?? '--',
                'prenom' => $user->info->prenom ?? '--',
            ],
            'status' => $user->status,
            'roles' => request()->user()->can(PermissionsEnum::VIEW_ROLES->value) ? $user->getRoleNames() : [],
            'permissions' => request()->user()->can(PermissionsEnum::VIEW_PERMISSIONS->value) ? $user->getDirectPermissions()->pluck('name')->toArray() : [],
            'last_login_at' => $user->last_login_at ? $user->last_login_at->diffForHumans() . ' (' . $user->last_login_ip . ')' : 'aucun',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    public function getDepartements()
    {
        return Departement::with('communes')->orderBy('name')->get()
            ->map(function ($departement) {
                $departement->counts = [
                    'communes' => $departement->communes->count(),
                    // 'quartiers' => $departement->communes->sum(fn($commune) => count($commune->quartiers)),
                    'arrondissements' => $departement->communes->sum(fn($commune) => $commune->arrondissements->count())
                ];
                $departement->communes->map(function ($commune) {
                    $commune->arrondissements_names = $commune->arrondissements->pluck('name');
                    return $commune->without(['arrondissements']);
                });
                return $departement;
            });
    }

    public function getInvitations()
    {
        $search = $this->getFilter('users', 'users_invitations');

        return Invitation::latest()
            ->when(!request()->user()->isRoot(), function ($query) {
                return $query->where('created_by', Auth::id());
            })
            ->where('email', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->paginate($this->getFilter('users_invitations', 'per_page'), pageName: filter_name(Invitation::class));
    }

    public function dashStats(): array
    {
        return
            [
                'Membres' => ['value' => User::onlyUsers()->count()],
                'Sessions d\'Agora' => ['value' => AgoraSession::count()],
                'Sondages Total' => ['value' => Poll::count()],
                'Sondages Actifs' => ['value' => Poll::notExpired()->count()],
                'Votes Enregistrés' => ['value' => PollVote::count()],
                'FAQs' => ['value' => FAQ::count()],
                'Départements' => ['value' => Departement::count()],
                'Communes' => ['value' => Commune::count()],
                'Arrondissements' => ['value' => Arrondissement::count()],
            ];
    }

    public function userStats(): array
    {
        $startOfWeek = now()->startOfWeek(); // Start of the week (Monday)
        $endOfWeek = now()->endOfWeek(); // End of the week (Sunday)

        return [
            'all_count' => User::count(),
            'members_count' => User::onlyUsers()->count(),
            'today_count' => User::onlyUsers()->whereDate('created_at', now())->count(),
            'show_today' => User::onlyUsers()->whereDate('created_at', now())->latest()->limit(6)->get(),
            'show_week' => User::role(RolesEnum::USER->value)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->latest()->limit(6)->get(),
            'week_count' => User::role(RolesEnum::USER->value)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->latest()->count(),
        ];
    }

    public function rolesStats()
    {
        $usersCount = User::count(); // Total d'utilisateurs
        $total = Role::withCount('users')->get()->sum('users_count');

        $roles = Role::withCount('users')
            ->orderByDesc('users_count') // Order by user count (descending)
            ->get()->map(function ($role) use ($usersCount, $total) {
                return [
                    'role' => $role->name,
                    'count' => $role->users_count,
                    'percentage' => $usersCount > 0 ? round(($role->users_count / $total) * 100, 2) : 0
                ];
            });

        return $roles;
    }

    public function topNeighbours()
    {
        $total = UserInfo::count();
        $totalNotNull = UserInfo::whereNotNull('quartier')->count();

        // Récupérer les 3 quartiers les plus fréquents
        $topQuartiers = DB::table('user_infos')
            ->whereNotNull('quartier')
            ->select('quartier', DB::raw('COUNT(quartier) as occurrences'))
            ->groupBy('quartier')
            ->orderByDesc('occurrences')
            ->limit(3)
            ->get();


        // Calculer le total des utilisateurs des 3 quartiers les plus fréquents
        $topQuartiersTotal = $topQuartiers->sum('occurrences');

        // Ajouter les pourcentages aux quartiers principaux
        $topQuartiers = $topQuartiers->map(function ($quartier) use ($total) {
            $quartier->pourcentage = round(($quartier->occurrences * 100) / $total, 2);
            return $quartier;
        });

        // Calcul du pourcentage des autres quartiers
        $autresOccurrences = $totalNotNull - $topQuartiersTotal;

        if ($autresOccurrences > 0) {
            $topQuartiers->push((object) [
                'quartier' => 'Autres',
                'occurrences' => $autresOccurrences,
                'pourcentage' => round(($autresOccurrences * 100) / $total, 2),
            ]);
        }

        $inconnus = UserInfo::whereNull('quartier')->count();
        if ($inconnus > 0) {
            $topQuartiers->push((object) [
                'quartier' => 'Inconnu',
                'occurrences' => $inconnus,
                'pourcentage' => round(($inconnus * 100) / $total, 2),
            ]);
        }

        // Retourner les résultats
        return $topQuartiers;
    }
}
