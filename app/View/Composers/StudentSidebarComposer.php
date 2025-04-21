<?php

namespace App\View\Composers;

use Illuminate\View\View;



class StudentSidebarComposer
{




    public function compose(View $view)
    {
        $data['currentRoute']     = \Request::route()->getName(); // return current route name

        $view->with('currentRoute', $data['currentRoute']);
    }
}
