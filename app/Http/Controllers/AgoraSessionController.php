<?php

namespace App\Http\Controllers;

use App\Models\AgoraSession;
use Illuminate\Http\Request;
use App\Helpers\ConfigHelper;
use App\Enums\PermissionsEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AgoraSessionRequest;
use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\AgoraSessionCollection;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AgoraSessionController extends BaseController implements HasMiddleware
{
    /**
     * Define middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware(
                'can:' . PermissionsEnum::MANAGE_AGORA_SESSIONS->value,
                only: ['store', 'update', 'destroy']
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $filterName = 'agora_sessions';
        $search = $this->getFilter($filterName, 'search');
        $perPage = $this->getFilter($filterName, 'per_page', 10);

        $collection = new AgoraSessionCollection(
            AgoraSession::latest()
                ->where('theme', 'like', '%' . $search . '%')
                ->paginate($perPage, pageName: $filterName)
        );

        return response()->json([
            'filter_name' => $filterName,
            'list' => $collection->toArray(request())
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
    public function store(AgoraSessionRequest $request)
    {
        $validated = $request->validated();

        $validated['image'] = $this->storeImage($request, 'agora_sessions');

        $session = AgoraSession::create($validated);

        return back()->with('success', "Session d'Agora crée avec succès.");
    }

    /**
     * Display the specified resource.
     */
    public function show(AgoraSession $session)
    {
        return $session;
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
    public function update(AgoraSessionRequest $request, AgoraSession $agora_session)
    {
        $validated = $request->validated();

        if ($imagePath = $this->storeImage($request, 'agora_sessions')) {
            $validated['image'] = $imagePath;
        }

        $agora_session->update($validated);

        return back()->with('success', "La session " . $agora_session->theme . " a été mise à jour avec succès.");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgoraSession $agora_session)
    {
        $agora_session->delete();

        return back()->with('success', "La session d'Agora a été supprimée avec succès.");
    }
}
