<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class UnitSearchComp extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $label = 'Unit', public bool $isDealer = false, public int $companyId = 0)
    {
    }

    public function dataName()
    {
        return $this->label . 'Search';
    }

    public function menuId()
    {
        return Str::slug($this->label);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.unit-search-comp');
    }
}
