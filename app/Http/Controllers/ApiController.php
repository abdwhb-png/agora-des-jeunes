<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Http\Controllers\Base\BaseController;
use App\Models\AppFeature;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\MongoDB\AiUsage;
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

    public function aiUsage(Request $request)
    {
        AiUsage::create([
            'user_id' => $request->user()->id,
            'ai' => $request->ai,
            'input_text' => $request->input_text,
            'output_text' => $request->output_text,
            'tokens_used' => $request->tokens_used,
            'metadata' => $request->metadata
        ]);
        return response()->json(['success' => true], 204);
    }
}
