<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class TabComp extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Collection $lists = new Collection(), public bool $isTabable = false, public int | null $commonParam = null)
    {}

    public function currentRouteName()
    {
        return Route::currentRouteName();
    }

    public function getParams($param)
    {
        if ($this->commonParam) {
            if ($param) {
                return [$this->commonParam, $param];
            } else {
                return [$this->commonParam];
            }
        } else {
            if ($param) {
                return [$param];
            }
        }
        return $param;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tab-comp');
    }
}
