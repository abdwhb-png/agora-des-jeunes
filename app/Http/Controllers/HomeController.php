<?php

namespace App\Http\Controllers;

use App\Meta;
use App\Models\FAQ;
use App\Models\User;
use Inertia\Inertia;
use App\Enums\SeoMeta;
use App\Models\AppFeature;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use App\Notifications\NewContact;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\ApplicationController;

class HomeController extends BaseController
{
    public function home()
    {
        Meta::addMeta('og:type', 'website');
        return Inertia::render('Home', [
            'features' => AppFeature::all(),
        ]);
    }

    public function about()
    {
        return Inertia::render(
            'About',
            [
                'meta' => SeoMeta::ABOUTUS->theMeta(),
            ]
        );
    }

    public function faqs()
    {
        return Inertia::render('Faqs', [
            'meta' => SeoMeta::FAQS->theMeta(),
            'faqs' => $this->paginatedFaqs(10),
            // 'categories' => FAQ::distinct('category')->where('is_active', true)->pluck('category'),
            'search_url' => "http://localhost:5678/webhook-test/89fb0db4-161b-4a34-b904-219ab5fd68b0",
        ]);
    }

    public function contact()
    {
        return Inertia::render(
            'Contact',
            [
                'meta' => SeoMeta::CONTACTUS->theMeta(),
            ]
        );
    }

    public function contactPerform(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'nullable|string',
            'prenom' => 'nullable|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string|max:500',
        ]);

        $contact = ContactForm::create([
            'email' => $request->email,
            'message' => $request->message,
            'entries' => $validated,
            'ip_address' => $request->ip(),
        ]);

        Notification::send(User::roots()->get(), new NewContact($contact));

        return back(303)->with('success', 'Merci pour votre message, nous vous contacterons sous peu.');
    }
}
