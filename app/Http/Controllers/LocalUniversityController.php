<?php

namespace App\Http\Controllers;

use App\Models\LocalUniversity;
use Illuminate\Http\Request;

class LocalUniversityController extends Controller
{
    // Afficher toutes les universités au Bénin
    public function index()
    {
        $universities = LocalUniversity::all();
        return view('universities_benin.index', compact('universities'));
    }

    // Afficher une université spécifique
    public function show(LocalUniversity $university)
    {
        return view('universities_benin.show', compact('university'));
    }

    // Afficher le formulaire de création d'une université
    public function create()
    {
        return view('universities_benin.create');
    }

    // Créer une nouvelle université
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'ranking' => 'nullable|integer',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        LocalUniversity::create($request->all());
        return back(303)->with('success', 'Université créée avec succès.');
    }

    // Afficher le formulaire de modification d'une université
    public function edit(LocalUniversity $university)
    {
        return view('universities_benin.edit', compact('university'));
    }

    // Mettre à jour une université
    public function update(Request $request, LocalUniversity $university)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'city' => 'sometimes|string',
            'ranking' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'website' => 'sometimes|url',
        ]);

        $university->update($request->all());
        return back(303)->with('success', 'Université mise à jour avec succès.');
    }

    // Supprimer une université
    public function destroy(LocalUniversity $university)
    {
        $university->delete();
        return back(303)->with('success', 'Université supprimée avec succès.');
    }
}