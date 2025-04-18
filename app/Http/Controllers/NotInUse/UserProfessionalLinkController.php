<?php

namespace App\Http\Controllers;

use App\Models\UserProfessionalLink;
use Illuminate\Http\Request;

class UserProfessionalLinkController extends Controller
{
    // Afficher toutes les relations utilisateur-professionnel
    public function index()
    {
        $links = UserProfessionalLink::all();
        return view('user_professional_links.index', compact('links'));
    }

    // Afficher une relation spécifique
    public function show(UserProfessionalLink $link)
    {
        return view('user_professional_links.show', compact('link'));
    }

    // Afficher le formulaire de création d'une relation
    public function create()
    {
        return view('user_professional_links.create');
    }

    // Créer une nouvelle relation
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'professional_id' => 'required|exists:professionals,id',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        UserProfessionalLink::create($request->all());
        return back(303)->with('success', 'Relation créée avec succès.');
    }

    // Afficher le formulaire de modification d'une relation
    public function edit(UserProfessionalLink $link)
    {
        return view('user_professional_links.edit', compact('link'));
    }

    // Mettre à jour une relation
    public function update(Request $request, UserProfessionalLink $link)
    {
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'professional_id' => 'sometimes|exists:professionals,id',
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);

        $link->update($request->all());
        return back(303)->with('success', 'Relation mise à jour avec succès.');
    }

    // Supprimer une relation
    public function destroy(UserProfessionalLink $link)
    {
        $link->delete();
        return back(303)->with('success', 'Relation supprimée avec succès.');
    }
}