<?php

namespace App\View\Components\layouts\parts;

use App\Models\User;
use Illuminate\View\Component;

class HeaderToolbarComp extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $userRoleName = '')
    {
        $userRoleName = User::join('roles', 'users.role_id', 'roles.id')->select('roles.name as role_name')->where('roles.id', auth()->user()->role_id)->first()->role_name;

        $this->userRoleName = $userRoleName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layouts.parts.header-toolbar-comp');
    }
}
