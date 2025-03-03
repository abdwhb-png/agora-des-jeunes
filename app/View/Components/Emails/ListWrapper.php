<?php

namespace App\View\Components\Emails;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListWrapper extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $list,
        public ?string $title = '',
        public bool $showIndex = true
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.emails.list-wrapper');
    }
}
