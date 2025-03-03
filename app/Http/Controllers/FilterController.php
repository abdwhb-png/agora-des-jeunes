<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Base\BaseController;

class FilterController extends BaseController
{

    protected $validationRules;

    public function __construct()
    {
        $this->validationRules = [
            'type' => ['required', 'string'],
            'filters' => ['array'],
        ];
    }

    public function index($type)
    {
        return $this->getFilter($type);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);

        // Récupérer les filtres existants ou un tableau vide par défaut
        $existingFilters = session()->get("filters.{$validated['type']}", []);

        // Fusionner uniquement si des filtres sont fournis
        if (!empty($validated['filters'])) {
            $filters = array_merge($existingFilters, $validated['filters']);
            session()->put("filters.{$validated['type']}", $filters);
        }

        return back()->with('success', 'Filtres appliqués pour ' . htmlspecialchars($validated['type']));
    }

    public function reset(Request $request)
    {
        $validated = $request->validate($this->validationRules);

        $newFilters = Arr::except(session()->get("filters.{$validated['type']}", []), array_keys($validated['filters']));

        if (empty($newFilters)) {
            session()->forget("filters.{$validated['type']}");
        } else {
            session()->put("filters.{$validated['type']}", $newFilters);
        }

        return back()->with('success', 'Filtres supprimés pour ' . htmlspecialchars($validated['type']));
    }
}