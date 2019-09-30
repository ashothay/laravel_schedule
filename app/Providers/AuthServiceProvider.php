<?php

namespace App\Providers;

use App\Http\Middleware\CheckUserRole;
use App\Policies\UserPolicy;
use App\Role\RoleChecker;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->app->singleton(CheckUserRole::class, function($app) {
            return new CheckUserRole(
                $app->make(RoleChecker::class)
            );
        });

        //
    }
}
