<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TrainingRequest;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class TrainingController extends BaseController implements HasMiddleware
{
    /**
     * Define middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware(
                'can:' . PermissionsEnum::MANAGE_JOB_OFFERS->value,
                only: ['store', 'update', 'destroy']
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $filterName = 'trainings';
        $filters = self::getFilter($filterName);
        $perPage = self::getFilter($filterName, 'per_page', 30);

        return response()->json([
            'filter_name' => $filterName,
            'list' => Training::latest()
                ->filter($filters)
                ->paginate($perPage, pageName: $filterName)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingRequest $request)
    {
        $validated = $request->validated();

        $validated['image'] = $this->storeImage($request, 'trainings');

        Training::create($validated);

        return back(303)->with('success', 'Formation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrainingRequest $request, Training $training)
    {
        $validated = $request->validated();

        if ($imagePath = $this->storeImage($request, 'trainings')) {
            $validated['image'] = $imagePath;
        }

        $training->update($validated);

        return back(303)->with('success', 'Formation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
