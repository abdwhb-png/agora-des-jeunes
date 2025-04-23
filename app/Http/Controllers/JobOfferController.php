<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\JobOfferRequest;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class JobOfferController extends BaseController implements HasMiddleware
{
    /**
     * Define middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware(
                'can:' . PermissionsEnum::MANAGE_TRAININGS->value,
                only: ['store', 'update', 'destroy']
            ),
        ];
    }

    // Afficher toutes les offres d'emploi
    public function index(): JsonResponse
    {
        $filterName = 'job_offers';
        $filters = self::getFilter($filterName);
        $perPage = self::getFilter($filterName, 'per_page', 30);

        return response()->json([
            'filter_name' => $filterName,
            'list' => JobOffer::latest()
                ->filter($filters)
                ->paginate($perPage, pageName: $filterName)
        ]);
    }

    // Afficher une offre d'emploi spécifique
    public function show(JobOffer $job)
    {
        return view('jobs.show', compact('job'));
    }

    // Afficher le formulaire de création d'une offre d'emploi
    public function create()
    {
        return view('jobs.create');
    }

    // Créer une nouvelle offre d'emploi
    public function store(JobOfferRequest $request)
    {
        $validated = $request->validated();

        $validated['image'] = $this->storeImage($request, 'job_offers');

        JobOffer::create($validated);

        return back(303)->with('success', 'Offre d\'emploi créée avec succès.');
    }

    // Afficher le formulaire de modification d'une offre d'emploi
    public function edit(JobOffer $job)
    {
        return view('jobs.edit', compact('job'));
    }

    // Mettre à jour une offre d'emploi
    public function update(JobOfferRequest $request, JobOffer $job)
    {
        $validated = $request->validated();

        if ($imagePath = $this->storeImage($request, 'job_offers')) {
            $validated['image'] = $imagePath;
        }

        $job->update($validated);

        return back(303)->with('success', 'Offre d\'emploi mise à jour avec succès.');
    }

    // Supprimer une offre d'emploi
    public function destroy(JobOffer $job_offer)
    {
        $job_offer->delete();
        return back(303)->with('success', 'Offre d\'emploi supprimée avec succès.');
    }
}
