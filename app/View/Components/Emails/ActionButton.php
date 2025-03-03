<?php

namespace App\View\Components\Emails;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ActionButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $url, public string $text, public string $type = "primary")
    {
        //
    }

    public function style(): object
    {
        $default = [
            'bg' => '#50cd89',
            'color' => '#FFFFFF'
        ];

        switch ($this->type) {
            case "primary":
                return (object)$default;
            case "secondary":
                return (object)[
                    'bg' => '#6c757d', // Example: Different background for secondary
                    'color' => '#FFFFFF'
                ];
            default:
                return (object)$default;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.emails.action-button');
    }
}
