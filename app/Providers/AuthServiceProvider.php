<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

		/*
		 * CS
		 */
		Gate::define('is-client', function (User $user) {
			return $user->role_id == 2;
		});

		/*
		 * CS
		 */
		Gate::define('is-vendor', function (User $user) {
			return $user->role_id == 3;
		});

		/*
		 * CS
		 */
		Gate::define('is-admin', function (User $user) {
			return $user->role_id == 1;
		});
    }
}
