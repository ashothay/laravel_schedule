<?php

namespace App\Providers;

use App\Http\Middleware\CheckUserRole;
use App\Role\RoleChecker;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
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
