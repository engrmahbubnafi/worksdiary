<?php

namespace App\View\Components\modals;

use Illuminate\View\Component;

class MasterModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public array $formAttr = [], public string $modalId = "bb-modal", public string $modalClass = "")
    {}

    public function hasForm()
    {
        return (bool) count($this->formAttr);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.master-modal');
    }
}
