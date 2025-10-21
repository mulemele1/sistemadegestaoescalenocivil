<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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
        /**$this->registerPolicies();

        Gate::define('is_user', function($user){
            return ($user->type == 'user' || $user->type == 'super' || $user->type == 'admin')
                        ? true
                        : false;
        });
        Gate::define('is_admin', function($user){
            return ($user->type == 'admin' || $user->type == 'super')
                        ? true
                        : false;
        });
        Gate::define('is_super', function($user){
            return ($user->type == 'super')
                        ? true
                        : false;
        });*/

        Gate ::define('is_user', function ($user) {
        return ($user->type == 'user' || $user->type == 'super' || $user->type == 'admin')
                        ? true
                        : false;
        });
        Gate ::define('is_admin', function ($user) {
            return ($user->type == 'admin' || $user->type == 'super')
                            ? true
                            : false;
        });
        Gate ::define('is_super', function ($user) {
            return ($user->type === 'super')
                            ? true
                            : false;
        });
    }
}
