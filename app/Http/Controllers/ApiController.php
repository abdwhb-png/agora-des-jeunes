<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Http\Controllers\Base\BaseController;
use App\Models\AppFeature;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends BaseController
{

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|' . implode('|', ConfigHelper::imageRules()),
        ]);

        $path = $this->storeImage($request);

        return response()->json(['url' => Storage::url($path)]);
    }

    public function getDepartements(): JsonResponse
    {
        return response()->json(
            [
                'departements' => Departement::with('communes.arrondissements')->get(),
                'communes' => Commune::with('arrondissements')->get(),
                'arrondissements' => Arrondissement::all(),
            ]
        );
    }

    public function getFeatures(): JsonResponse
    {
        return response()->json(
            [
                'app_features' => AppFeature::all(),
            ]
        );
    }
}