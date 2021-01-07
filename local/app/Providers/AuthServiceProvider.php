<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
    // public function boot()
    // {
    //     $this->registerPolicies();

    //     //
    // }

    public function boot(GateContract $gate)
    {
        $this->registerPolicies();
        $gate->define('IsAdmin', function ($user) {
            return $user->id_type == '1';
        });

        $gate->define('IsAdminFac', function ($user) {
            return $user->id_type == '3';
        });

        $gate->define('IsEmployee_fac', function ($user) {
            return $user->id_type == '7';
        });
    
        $gate->define('IsEmployee_shop', function ($user) {
            return $user->id_type == '6';
        });

        $gate->define('IsSale', function ($user) {
            return $user->id_type == '8';
        });

        $gate->define('IsOffal', function ($user) {
            return $user->id_type == '9';
        });

        $gate->define('IsCut', function ($user) {
            return $user->id_type == '10';
        });

    }
}
