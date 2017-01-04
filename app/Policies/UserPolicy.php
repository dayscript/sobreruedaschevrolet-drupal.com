<?php

namespace App\Policies;

use App\User;
use App\Manager\Programs\Program;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine if the user can list records
     *
     * @param  \App\User $user
     * @param User $user2
     * @return bool
     */
    public function list(User $user, User $user2)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','users')->where('list',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can list users of a given program
     *
     * @param  \App\User $user
     * @param User $user2
     * @param Program $program
     * @return bool
     */
    public function listByProgram(User $user, User $user2, Program $program)
    {
        return $this->list($user, $user2) && $user->inProgram($program->id);
    }
    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param User $user2
     * @return bool
     */
    public function show(User $user, User $user2)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','users')->where('show',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can create records
     *
     * @param  \App\User $user
     * @param User $user2
     * @return bool
     */
    public function create(User $user, User $user2)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','users')->where('create',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can edit records
     *
     * @param  \App\User $user
     * @param User $user2
     * @return bool
     */
    public function edit(User $user, User $user2)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','users')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can destroy records
     *
     * @param  \App\User $user
     * @param User $user2
     * @return bool
     */
    public function destroy(User $user, User $user2)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','users')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
