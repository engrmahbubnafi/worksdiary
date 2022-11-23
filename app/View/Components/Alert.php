<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{

    /**
     * The alert type.
     *
     * @var string
     */
   // public $type;

    /**
     * The properties / methods that should not be exposed to the component template.
     *
     * @var array
     */
    //protected $except = ['type'];

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
