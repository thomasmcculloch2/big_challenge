<?php

declare(strict_types=1);

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Constants\Rol;
use App\Models\Submission;
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
         //'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('canGetOneSubmission', function (User $user, Submission $submission) {
            if ($user->hasRole(Rol::DOCTOR)) {
                return true;
            }
            return $user->id === $submission->patient_id;
        });

        Gate::define('doctorBelongsToSubmission', function (User $user, Submission $submission) {
            return $user->hasRole(Rol::DOCTOR) && $user->id === $submission->doctor_id;
        });
        Gate::define('patientBelongsToSubmission', function (User $user, Submission $submission) {
            return $user->hasRole(Rol::PATIENT) && $user->id === $submission->patient_id;
        });
    }
}
