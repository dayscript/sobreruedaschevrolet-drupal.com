<?php

namespace App\Policies;

use App\User;
use App\Manager\Programs\Program;
use App\Manager\Challenges\Variable;
use Illuminate\Auth\Access\HandlesAuthorization;

class VariablePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Allows user with id=1 to access all data
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->id == 1) {
            return true;
        }
    }


    /**
     * Determine if the user can list variables
     *
     * @param  \App\User $user
     * @param Variable $variable
     * @return bool
     */
    public function list(User $user, Variable $variable)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','variables')->where('list',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can list variables of a given program
     *
     * @param  \App\User $user
     * @param Variable $variable
     * @param Program $program
     * @return bool
     */
    public function listByProgram(User $user, Variable $variable, Program $program)
    {
        return $this->list($user, $variable) && $user->inProgram($program->id);
    }

    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param Variable $variable
     * @return bool
     */
    public function show(User $user, Variable $variable)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','variables')->where('show',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if user can create variables.
     *
     * @param  \App\User $user
     * @param Variable $variable
     * @return bool
     */
    public function create(User $user, Variable $variable)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','variables')->where('create',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given challenge can be edited by the user.
     *
     * @param  \App\User $user
     * @param Variable $variable
     * @return bool
     */
    public function edit(User $user, Variable $variable)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','variables')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given challenge can be deleted by the user.
     *
     * @param  \App\User $user
     * @param Variable $variable
     * @return bool
     */
    public function destroy(User $user, Variable $variable)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','variables')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
