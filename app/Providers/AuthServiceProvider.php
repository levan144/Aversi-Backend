<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Patient' => 'App\Policies\PatientPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        Passport::tokensCan([
            'patient' => 'Patient User Type',
            'doctor' => 'Doctor User Type',
        ]);
    }
}
