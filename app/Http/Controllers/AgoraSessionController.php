<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\AgoraSessionRequest;
use App\Http\Resources\AgoraSessionCollection;
use App\Models\AgoraSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgoraSessionController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = $this->paginatedAgoraSessions(50);

        return response()->json($data);
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
    public function destroy(string $id)
    {
        //
    }
}
