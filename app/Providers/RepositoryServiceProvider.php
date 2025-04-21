<?php

namespace App\Providers;

use App\Interfaces\CartInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\SettingInterface;
use App\Repositories\CartRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Interfaces\FlagIconInterface;
use App\Interfaces\LanguageInterface;
use App\Interfaces\PermissionInterface;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\FlagIconRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\PermissionRepository;
use App\Interfaces\GeneralSettingInterface;
use App\Repositories\AuthenticationRepository;
use App\Repositories\GeneralSettingRepository;
use App\Interfaces\AuthenticationRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthenticationRepositoryInterface::class, AuthenticationRepository::class);
        $this->app->bind(RoleInterface::class,                     RoleRepository::class);
        $this->app->bind(PermissionInterface::class,               PermissionRepository::class);
        $this->app->bind(UserInterface::class,                     UserRepository::class);
        $this->app->bind(GeneralSettingInterface::class,           GeneralSettingRepository::class);
        $this->app->bind(SettingInterface::class,                  SettingRepository::class);
        $this->app->bind(LanguageInterface::class,                 LanguageRepository::class);
        $this->app->bind(FlagIconInterface::class,                 FlagIconRepository::class);
        $this->app->bind(CartInterface::class,                     CartRepository::class);

        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
