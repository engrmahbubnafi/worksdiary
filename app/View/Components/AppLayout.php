<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * The user collection.
     *
     * @var Collection
     */
    // public $user;

    /**
     * The role name of the user.
     *
     * @var string
     */
    // public $role;

    /**
     * Create the component instance.
     *
     * @param Collection $user
     * @param string $role
     * @return void
     */
    // public function __construct($user, $role)
    // {
    //     $user = Auth::user();
    //     $this->user = $user;

    //     $role = User::join('roles', 'users.role_id', 'roles.id')
    //         ->select('roles.name')
    //         ->where('roles.id', $user->role_id)
    //         ->get('name');
    //     $this->role = $role;
    // }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
