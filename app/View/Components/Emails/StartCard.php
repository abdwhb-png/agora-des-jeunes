<?php

namespace App\View\Components\Emails;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StartCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = '',
        public string $media = '',
        public string $actionUrl = '',
        public string $actionText = 'Aller Maintenant'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.emails.start-card');
    }
}
