<?php

namespace App\View\Components\Emails;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logo extends Component
{
    public string $logo;

    /**
     * Create a new component instance.
     */
    public function __construct($path = null)
    {
        $this->logo = $path ?? asset('images/logo.png');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.emails.logo');
    }
}
