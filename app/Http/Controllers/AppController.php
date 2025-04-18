<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Inertia\Inertia;
use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\ApplicationController;

class AppController extends BaseController
{
    protected $pageDir = 'App/';

    public function onboarding()
    {
        return Inertia::render($this->pageDir . 'OnBoarding', [
            'cities' => Commune::all(),
        ]);
    }

    public function dashboard()
    {
        return Inertia::render($this->pageDir . 'Dashboard');
    }

    public function profil()
    {
        $filters = request()->all('search_cv', 'search_project');
        return Inertia::render('Member/Profile', [
            'filters' => $filters,
            'projects' => request()->user()->projects()
                ->where('title', 'like', '%' . $filters['search_project'] . '%')
                ->latest()->paginate(10, pageName: 'projects')
                ->withQueryString(),
            'cvs' => CV::where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhere('user_email', Auth::user()->email);
            })
                ->where('title', 'like', '%' . $filters['search_cv'] . '%')
                ->latest()->paginate(10, pageName: 'cvs')
                ->withQueryString(),
        ]);
    }

    public function projets()
    {
        $search  = request()->get('search_project');
        return Inertia::render($this->pageDir . 'Projects', [
            'projects' => Auth::user()->projects()
                ->where('title', 'like', '%' . $search . '%')
                ->latest()
                ->paginate(10, pageName: 'projects')
                ->withQueryString(),
        ]);
    }

    public function entreprendre()
    {
        return Inertia::render($this->pageDir . 'Entreprendre');
    }

    public function formation()
    {
        return Inertia::render($this->pageDir . 'Formation');
    }

    public function emploi()
    {
        return Inertia::render($this->pageDir . 'Emploi');
    }
}
