<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use App\Traits\ResourceCollectionTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersCollection extends ResourceCollection
{
    use ResourceCollectionTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Transform each item in the collection
        $data = $this->collection->map(function ($item) use ($request) {
            if ($request->user()) {
                $roles = $request->user()->can(PermissionsEnum::VIEW_ROLES->value) ? $item->getRoleNames() : [];
                $permissions = $request->user()->can(PermissionsEnum::VIEW_PERMISSIONS->value) ? $item->getDirectPermissions()->pluck('name')->toArray() : [];
            }
            return  [
                ...$item->toArray(),
                'full_name' => $item->info->full_name,
                'base' => [
                    'tel' => $item->phone ?? '--',
                    'nom' => $item->info->nom ?? '--',
                    'prenom' => $item->info->prenom ?? '--',
                ],
                'roles' => isset($roles) ? $roles : [],
                'permissions' => isset($permissions) ? $permissions : [],
                'last_login_at' => $item->last_login_at ? $item->last_login_at->diffForHumans() . ' (' . $item->last_login_ip . ')' : 'aucun',
            ];
        });

        // Return the paginated response with the transformed data
        return $this->pagination($data);
    }
}
