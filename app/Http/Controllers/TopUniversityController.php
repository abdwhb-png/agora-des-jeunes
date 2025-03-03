<?php

namespace App\Http\Controllers;

use App\Models\TopUniversity;
use Illuminate\Http\Request;

class TopUniversityController extends Controller
{
    // Afficher toutes les meilleures universités dans le monde
    public function index()
    {
        $universities = TopUniversity::all();
        return view('top_universities_world.index', compact('universities'));
    }

    // Afficher une université spécifique
    public function show(TopUniversity $university)
    {
        return view('top_universities_world.show', compact('university'));
    }

    // Afficher le formulaire de création d'une université
    public function create()
    {
        return view('top_universities_world.create');
    }

    // Créer une nouvelle université
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'ranking' => 'nullable|integer',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        TopUniversity::create($request->all());
        return back(303)->with('success', 'Université créée avec succès.');
    }

    // Afficher le formulaire de modification d'une université
    public function edit(TopUniversity $university)
    {
        return view('top_universities_world.edit', compact('university'));
    }

    // Mettre à jour une université
    public function update(Request $request, TopUniversity $university)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'country' => 'sometimes|string',
            'ranking' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'website' => 'sometimes|url',
        ]);

        $university->update($request->all());
        return back(303)->with('success', 'Université mise à jour avec succès.');
    }

    // Supprimer une université
    public function destroy(TopUniversity $university)
    {
        $university->delete();
        return back(303)->with('success', 'Université supprimée avec succès.');
    }
}