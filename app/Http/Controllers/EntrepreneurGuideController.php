<?php

namespace App\Http\Controllers;

use App\Models\EntrepreneurGuide;
use Illuminate\Http\Request;

class EntrepreneurGuideController extends Controller
{
    // Afficher tous les guides
    public function index()
    {
        $guides = EntrepreneurGuide::all();
        return view('entrepreneur_guides.index', compact('guides'));
    }

    // Afficher un guide spécifique
    public function show(EntrepreneurGuide $guide)
    {
        return view('entrepreneur_guides.show', compact('guide'));
    }

    // Afficher le formulaire de création d'un guide
    public function create()
    {
        return view('entrepreneur_guides.create');
    }

    // Créer un nouveau guide
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        EntrepreneurGuide::create($request->all());
        return back(303)->with('success', 'Guide créé avec succès.');
    }

    // Afficher le formulaire de modification d'un guide
    public function edit(EntrepreneurGuide $guide)
    {
        return view('entrepreneur_guides.edit', compact('guide'));
    }

    // Mettre à jour un guide
    public function update(Request $request, EntrepreneurGuide $guide)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
        ]);

        $guide->update($request->all());
        return back(303)->with('success', 'Guide mis à jour avec succès.');
    }

    // Supprimer un guide
    public function destroy(EntrepreneurGuide $guide)
    {
        $guide->delete();
        return back(303)->with('success', 'Guide supprimé avec succès.');
    }
}