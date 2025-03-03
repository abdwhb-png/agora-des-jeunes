<?php

namespace App\Http\Controllers;

use App\Http\Requests\CvRequest;
use App\Models\Cv;
use App\Models\User;
use App\Models\CvInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CvResource;
use Illuminate\Support\Facades\DB;

class CvController extends Controller
{
    // Afficher tous les CVs d'un user
    public function index()
    {
        $email = request()->get('user_email');
        return response()->json([
            'data' => CvResource::collection(Cv::where('user_email', $email)->get()),
        ]);
    }

    // Afficher un CV
    public function getResume(CV $cv): JsonResponse
    {
        return response()->json(['data' => new CvResource($cv)]);
    }

    // Créer un nouveau CV
    public function store(CvRequest $request): JsonResponse
    {
        $request->validated();

        $user = User::where('email', $request->user_email)->first();

        $cv = new CV([
            'user_id' => $request->user_id ?? ($user ? $user->id : null),
            'user_email' => $request->user_email,
            'resume_id' => Str::uuid(),
            'title' => $request->title,
            'theme_color' => $request->theme_color,
            'sections' => $request->sections,
        ]);

        try {
            DB::Transaction(function () use ($cv) {
                $cv->save();
            });

            return response()->json([
                'success' => 'CV créé avec succès.',
                'data' => new CvResource($cv),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mettre à jour un CV
    public function update(CvRequest $request, CV $cv): JsonResponse
    {
        $request->validated();

        CvInfo::updateOrCreate(
            ['cv_id' => $cv->id],
            $request->except('file_path', 'theme_color')
        );

        if ($request->file_path || $request->theme_color) {
            $cv->update($request->only('file_path', 'theme_color'));
        }

        return  response()->json([
            'success' => 'CV mis à jour avec succès.',
            'data' => new CvResource($cv),
        ]);
    }

    // Supprimer un CV
    public function destroy(CV $cv): JsonResponse
    {
        $cv->delete();
        return response()->json(['success' => 'CV supprimé avec succès.']);
    }
}