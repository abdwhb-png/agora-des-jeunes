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
            'filters' => ['sometimes', 'array'],
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
        // Adjust validation: 'filters' is not always required for reset
        $validated = $request->validate($this->validationRules);

        $sessionKey = "filters.{$validated['type']}";

        // If specific filters are provided in the request (for partial reset, though unlikely with current frontend)
        if (!empty($validated['filters'])) {
            $existingFilters = session()->get($sessionKey, []);
            $keysToRemove = array_keys($validated['filters']);
            $newFilters = Arr::except($existingFilters, $keysToRemove);

            if (empty($newFilters)) {
                session()->forget($sessionKey);
            } else {
                session()->put($sessionKey, $newFilters);
            }
        } else {
            // No 'filters' key in request, assume full reset for the type
            session()->forget($sessionKey);
        }

        return back()->with('success', 'Filtres réinitialisés pour ' . htmlspecialchars($validated['type']));
    }
}
