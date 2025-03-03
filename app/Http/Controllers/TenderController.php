<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    // Afficher tous les appels d'offres
    public function index()
    {
        $tenders = Tender::all();
        return view('tenders.index', compact('tenders'));
    }

    // Afficher un appel d'offres spécifique
    public function show(Tender $tender)
    {
        return view('tenders.show', compact('tender'));
    }

    // Afficher le formulaire de création d'un appel d'offres
    public function create()
    {
        return view('tenders.create');
    }

    // Créer un nouvel appel d'offres
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'organization' => 'required|string',
            'deadline' => 'required|date',
            'description' => 'required|string',
            'application_link' => 'nullable|url',
        ]);

        Tender::create($request->all());
        return back(303)->with('success', 'Appel d\'offres créé avec succès.');
    }

    // Afficher le formulaire de modification d'un appel d'offres
    public function edit(Tender $tender)
    {
        return view('tenders.edit', compact('tender'));
    }

    // Mettre à jour un appel d'offres
    public function update(Request $request, Tender $tender)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'organization' => 'sometimes|string',
            'deadline' => 'sometimes|date',
            'description' => 'sometimes|string',
            'application_link' => 'sometimes|url',
        ]);

        $tender->update($request->all());
        return back(303)->with('success', 'Appel d\'offres mis à jour avec succès.');
    }

    // Supprimer un appel d'offres
    public function destroy(Tender $tender)
    {
        $tender->delete();
        return back(303)->with('success', 'Appel d\'offres supprimé avec succès.');
    }
}