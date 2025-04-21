<?php

namespace App\View\Composers;

use Illuminate\View\View;



class InstructorSidebarComposer
{




    public function compose(View $view)
    {
        $data['currentRoute']     = \Request::route()->getName(); // return current route name

        $view->with('currentRoute', $data['currentRoute']);
    }
}
