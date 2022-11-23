<?php
namespace App\View\Composers;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class MenuComposer
{

    public function compose(View $view)
    {
        $view->with('menu_list', App::make('premitedMenuArr'));
    }
}
