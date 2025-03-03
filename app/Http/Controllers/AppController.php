<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends BaseController
{
    protected $pageDir = 'App/';

    public function dashboard()
    {
        return Inertia::render($this->pageDir . 'Dashboard');
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