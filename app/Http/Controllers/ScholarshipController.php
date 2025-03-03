<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    // Afficher toutes les bourses
    public function index()
    {
        $scholarships = Scholarship::all();
        return view('scholarships.index', compact('scholarships'));
    }

    // Afficher une bourse spécifique
    public function show(Scholarship $scholarship)
    {
        return view('scholarships.show', compact('scholarship'));
    }

    // Afficher le formulaire de création d'une bourse
    public function create()
    {
        return view('scholarships.create');
    }

    // Créer une nouvelle bourse
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'provider' => 'required|string',
            'country' => 'required|string',
            'eligibility' => 'required|string',
            'deadline' => 'nullable|date',
            'application_link' => 'nullable|url',
        ]);

        Scholarship::create($request->all());
        return back(303)->with('success', 'Bourse créée avec succès.');
    }

    // Afficher le formulaire de modification d'une bourse
    public function edit(Scholarship $scholarship)
    {
        return view('scholarships.edit', compact('scholarship'));
    }

    // Mettre à jour une bourse
    public function update(Request $request, Scholarship $scholarship)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'provider' => 'sometimes|string',
            'country' => 'sometimes|string',
            'eligibility' => 'sometimes|string',
            'deadline' => 'sometimes|date',
            'application_link' => 'sometimes|url',
        ]);

        $scholarship->update($request->all());
        return back(303)->with('success', 'Bourse mise à jour avec succès.');
    }

    // Supprimer une bourse
    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();
        return back(303)->with('success', 'Bourse supprimée avec succès.');
    }
}