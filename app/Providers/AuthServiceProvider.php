<?php

namespace App\Providers;

use App\Models\{User, Post};
use App\Policies\OldPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cookie;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*Gate::before(function(User $user){
            if($user->isAdmin())
                return true;
        });*/

        //Gate::resource('post', OldPostPolicy::class);

        Gate::define('see-content', function(User $user = null){
            return $user || Cookie::get('accept_terms') === '1';
        });
    }
}
