<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleCollection;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends BaseController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:' . PermissionsEnum::VIEW_ROLES->value, only: ['index']),
            new Middleware('can:' . PermissionsEnum::CREATE_ROLE->value, only: ['store', 'create']),
            new Middleware('can:' . PermissionsEnum::EDIT_ROLE->value, only: ['update', 'edit']),
            new Middleware('can:' . PermissionsEnum::DELETE_ROLE->value, only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = $this->getFilter('roles', 'search');
        $isRoot = request()->user()->isRoot();

        $query = Role::when(!$isRoot, function ($query) {
            return $query->where('name', '!=', RolesEnum::ROOT->value);
        })
            ->orderBy('name')
            ->with("permissions");

        // Cloner la requête pour éviter de l'altérer
        $allData = (clone $query)->get();

        $resource = new RoleCollection(
            $query->where('name', 'like', '%' . $search . '%')
                ->paginate($this->perPage($this->getFilter('roles', 'per_page')), pageName: filter_name(Role::class))
        );

        return request()->wantsJson() ? $allData : Inertia::render('Gestion/Roles', [
            'roles' => $resource->toArray(request()),
            'can' => [
                'editRole' => request()->user()->can(PermissionsEnum::EDIT_ROLE->value),
                'createRole' => request()->user()->can(PermissionsEnum::CREATE_ROLE->value),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        Role::create($validated);
        return back()->with('success', 'Role crée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        if ($request->permissions) {
            $perms = $validated['permissions']['status']
                ? Permission::whereIn('id', $validated['permissions']['value'])->pluck('name')
                : [];
            $role->syncPermissions($perms);

            return back()->with('success', $validated['permissions']['status'] ? 'Toutes les permissions ont étées attribué au role.' : 'Toutes les permissions ont étées retiré au role.');
        } else if ($request->permission) {
            $perm = Permission::findOrFail($validated['permission']['id']);

            if ($validated['permission']['status']) {
                $role->givePermissionTo($perm);
                $message = " attribué au role avec succès.";
            } else {
                $role->revokePermissionTo($perm);
                $message = " retiré du role avec succès.";
            }

            return back()->with('success', 'Permission ' . $perm->name . $message);
        } else {
            $role->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);
            return back()->with('success', 'Role mis à jour avec succès.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}