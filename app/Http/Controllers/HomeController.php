<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\AppFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\ApplicationController;
use App\Models\FAQ;

class HomeController extends BaseController
{
    protected function sendContactMail(array $input)
    {
        try {
            //TODO: Send email
        } catch (\Exception $e) {
            return false;
        }
    }

    public function home()
    {
        return Inertia::render('Home', [
            'features' => AppFeature::all(),
        ]);
    }

    public function faqs()
    {
        return Inertia::render('Faqs', [
            'faqs' => $this->paginatedFaqs(10),
            // 'categories' => FAQ::distinct('category')->where('is_active', true)->pluck('category'),
            'search_url' => "http://localhost:5678/webhook-test/89fb0db4-161b-4a34-b904-219ab5fd68b0",
        ]);
    }

    public function contact(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string|max:500',
        ]);

        $this->sendContactMail($request->all());

        return back(303)->with('success', 'Merci pour votre message, nous vous contacterons sous peu.');
    }
}
