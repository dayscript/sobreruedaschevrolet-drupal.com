<?php

namespace App\Providers;

use App\Manager\Challenges\Goal;
use App\Manager\Challenges\Variable;
use App\Manager\Programs\Program;
use App\Manager\User\Goalvalue;
use App\Manager\User\ImportTemplate;
use App\Policies\GoalPolicy;
use App\Policies\ImportTemplatePolicy;
use App\Policies\ProgramPolicy;
use App\Policies\UserValuePolicy;
use App\Policies\VariablePolicy;
use App\User;
use App\Manager\User\Role;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Manager\User\Permission;
use App\Policies\ChallengePolicy;
use App\Policies\PermissionPolicy;
use App\Manager\Challenges\Challenge;
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
        Role::class => RolePolicy::class,
        Program::class => ProgramPolicy::class,
        Permission::class => PermissionPolicy::class,
        ImportTemplate::class => ImportTemplatePolicy::class,
        User::class => UserPolicy::class,
        Challenge::class => ChallengePolicy::class,
        Variable::class => VariablePolicy::class,
        Goal::class => GoalPolicy::class,
        Goalvalue::class => UserValuePolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
