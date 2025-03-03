<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionCollection;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends BaseController implements HasMiddleware
{
    protected $validationRules;

    public static function middleware(): array
    {
        return [
            new Middleware('can:' . PermissionsEnum::VIEW_PERMISSIONS->value, only: ['index']),
            new Middleware('can:' . PermissionsEnum::CREATE_PERMISSION->value, only: ['store', 'create']),
            new Middleware('can:' . PermissionsEnum::EDIT_PERMISSION->value, only: ['update', 'edit']),
            new Middleware('can:' . PermissionsEnum::DELETE_PERMISSION->value, only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->validationRules =
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:500'],
            ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = $this->getFilter('permissions', 'search');

        $query = Permission::orderBy('name')
            ->with("roles");

        // Cloner la requête pour éviter de l'altérer
        $allData = (clone $query)->get();

        $resource = new PermissionCollection(
            $query->where('name', 'like', '%' . $search . '%')
                ->paginate($this->perPage($this->getFilter('permissions', 'per_page')), pageName: filter_name(Permission::class))
        );

        return request()->wantsJson() ? $allData : Inertia::render('Gestion/Permissions', [
            'permissions' => $resource->toArray(request()),
            'can' => [
                'editPermission' => request()->user()->can(PermissionsEnum::EDIT_PERMISSION->value),
                'createPermission' => request()->user()->can(PermissionsEnum::CREATE_PERMISSION->value),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);
        Permission::create($validated);
        return back()->with('success', 'Permission crée avec succès.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission supprimée avec succès.');
    }
}
