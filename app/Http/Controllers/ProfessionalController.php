<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    // Afficher tous les professionnels
    public function index()
    {
        $professionals = Professional::all();
        return view('professionals.index', compact('professionals'));
    }

    // Afficher un professionnel spécifique
    public function show(Professional $professional)
    {
        return view('professionals.show', compact('professional'));
    }

    // Afficher le formulaire de création d'un professionnel
    public function create()
    {
        return view('professionals.create');
    }

    // Créer un nouveau professionnel
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'profession' => 'required|string',
            'location' => 'nullable|string',
            'contact_info' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        Professional::create($request->all());
        return back(303)->with('success', 'Professionnel créé avec succès.');
    }

    // Afficher le formulaire de modification d'un professionnel
    public function edit(Professional $professional)
    {
        return view('professionals.edit', compact('professional'));
    }

    // Mettre à jour un professionnel
    public function update(Request $request, Professional $professional)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'profession' => 'sometimes|string',
            'location' => 'sometimes|string',
            'contact_info' => 'sometimes|string',
            'bio' => 'sometimes|string',
        ]);

        $professional->update($request->all());
        return back(303)->with('success', 'Professionnel mis à jour avec succès.');
    }

    // Supprimer un professionnel
    public function destroy(Professional $professional)
    {
        $professional->delete();
        return back(303)->with('success', 'Professionnel supprimé avec succès.');
    }
}