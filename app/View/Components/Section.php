<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Section extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     *  @return \Illuminate\Contracts\View\View|\Closure|string
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return function ($componentData) {
            return <<<BLADE
                @section("{$componentData['attributes']->get('name')}")
                    {$componentData['slot']}
                @endsection
            BLADE;
        };
    }
}
