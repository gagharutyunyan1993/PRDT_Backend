<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::loadKeysFrom(__DIR__.'/keys');

        Gate::define('view',function (User $user, $modelArgument){
            return $user->hasAccess("view_{$modelArgument}" || $user->hasAccess("edit_{$modelArgument}"));
        });

        Gate::define('edit',function (User $user, $modelArgument){
            return $user->hasAccess("edit_{$modelArgument}");
        });
    }
}
