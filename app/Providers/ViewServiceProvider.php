<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\View\Composers\FooterComposer;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\LanguageComposer;
use App\View\Composers\ForumSideBarComposer;
use App\View\Composers\StudentSidebarComposer;
use App\View\Composers\InstructorSidebarComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('frontend.layouts.partials.footer',                          FooterComposer::class);
        View::composer('frontend.student.dashboard.layouts.master',                 StudentSidebarComposer::class);
        View::composer('frontend.instructor.dashboard.layouts.master',              InstructorSidebarComposer::class);

        View::composer('frontend.student.layouts.master',       StudentSidebarComposer::class);
        View::composer('forum::components.sidebar',       ForumSideBarComposer::class);
    }
}
