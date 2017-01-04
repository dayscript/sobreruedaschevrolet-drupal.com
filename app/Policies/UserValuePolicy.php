<?php

namespace App\Policies;

use App\Manager\Challenges\Goal;
use App\User;
use App\Manager\User\Goalvalue;
use App\Manager\Programs\Program;
use App\Manager\Challenges\Variable;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserValuePolicy
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
     * @param Goalvalue $value
     * @return bool
     */
    public function list(User $user, Goalvalue $value)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','user_goals')->where('list',1)->first())
                return true;
        }
        return false;
    }


    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param Goalvalue $value
     * @return bool
     */
    public function show(User $user, Goalvalue $value)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','user_goals')->where('show',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if user can create variables.
     *
     * @param  \App\User $user
     * @param Goalvalue $value
     * @return bool
     */
    public function create(User $user, Goalvalue $value)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','user_goals')->where('create',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given challenge can be edited by the user.
     *
     * @param  \App\User $user
     * @param Goalvalue $value
     * @return bool
     */
    public function edit(User $user, Goalvalue $value)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','user_goals')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given challenge can be deleted by the user.
     *
     * @param  \App\User $user
     * @param Goalvalue $value
     * @return bool
     */
    public function destroy(User $user, Goalvalue $value)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','user_goals')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
