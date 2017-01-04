<?php

namespace App\Policies;

use App\User;
use App\Manager\User\Role;
use App\Manager\Programs\Program;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
     * Determine if the user can list roles
     *
     * @param  \App\User $user
     * @param Role $role
     * @return bool
     */
    public function list(User $user, Role $role)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','roles')->where('list',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can list roles of a given project
     *
     * @param  \App\User $user
     * @param Role $role
     * @param Program $program
     * @return bool
     */
    public function listByProgram(User $user, Role $role, Program $program)
    {
        return $this->list($user, $role) && $user->inProgram($program->id);
    }

    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param Role $role
     * @return bool
     */
    public function show(User $user, Role $role)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','roles')->where('show',1)->first())
                return true;
        }
        return false;
    }
    /**
     * Determine if the given role can be created by the user.
     *
     * @param  \App\User $user
     * @param Role $role
     * @return bool
     */
    public function create(User $user, Role $role)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','roles')->where('create',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given role can be edited by the user.
     *
     * @param  \App\User $user
     * @param Role $role
     * @return bool
     */
    public function edit(User $user, Role $role)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','roles')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given role can be deleted by the user.
     *
     * @param  \App\User $user
     * @param Role $role
     * @return bool
     */
    public function destroy(User $user, Role $role)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','roles')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
