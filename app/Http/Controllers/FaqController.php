<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\FaqRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

/**
 * Controller for managing FAQ items
 */
class FaqController extends BaseController implements HasMiddleware
{
    /**
     * Define middleware for this controller
     */
    public static function middleware(): array
    {
        return [
            new Middleware(
                'can:' . PermissionsEnum::MANAGE_FAQS->value,
                only: ['store', 'update', 'destroy']
            ),
        ];
    }

    /**
     * Display a listing of FAQs
     * 
     * @return \Illuminate\Http\Response JSON response with FAQ data
     */
    public function index()
    {
        $filterName = 'faqs';
        $filters = $this->getFilter($filterName);
        $perPage = $this->getFilter($filterName, 'per_page', 10);

        return response()->json([
            'filter_name' => $filterName,
            'list' => FAQ::orderBy('category')
                ->filter($filters)
                ->paginate($perPage, pageName: $filterName)
        ]);
    }

    /**
     * Display the specified FAQ
     *
     * @param  \App\Models\FAQ  $faq The FAQ model instance
     * @return \Illuminate\Http\Response JSON response with FAQ data
     */
    public function show(FAQ $faq)
    {
        return response()->json($faq);
    }

    /**
     * Store a newly created FAQ
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirect with success message
     */
    public function store(FaqRequest $request)
    {
        $validated = $request->validated();

        FAQ::create($validated);

        return back(303)->with('success', 'FAQ ajoutée avec succès');
    }

    /**
     * Update the specified FAQ
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request
     * @param  \App\Models\FAQ  $faq The FAQ model instance
     * @return \Illuminate\Http\RedirectResponse Redirect with success message
     */
    public function update(FaqRequest $request, FAQ $faq)
    {
        $validated = $request->validated();

        $faq->update($validated);

        return back(303)->with('success', 'FAQ mise à jour avec succès');
    }

    /**
     * Remove the specified FAQ
     *
     * @param  \App\Models\FAQ  $faq The FAQ model instance
     * @return \Illuminate\Http\RedirectResponse Redirect with success message
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return back(303)->with('success', 'FAQ supprimé avec succès');
    }
}
