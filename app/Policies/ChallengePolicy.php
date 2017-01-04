<?php

namespace App\Policies;

use App\User;
use App\Manager\Challenges\Challenge;
use App\Manager\Programs\Program;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallengePolicy
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
     * Determine if the user can list challenges
     *
     * @param  \App\User $user
     * @param Challenge $challenge
     * @return bool
     */
    public function list(User $user, Challenge $challenge)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','challenges')->where('list',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can list challenges of a given program
     *
     * @param  \App\User $user
     * @param Challenge $challenge
     * @param Program $program
     * @return bool
     */
    public function listByProgram(User $user, Challenge $challenge, Program $program)
    {
        return $this->list($user, $challenge) && $user->inProgram($program->id);
    }

    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param Challenge $challenge
     * @return bool
     */
    public function show(User $user, Challenge $challenge)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','challenges')->where('show',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if user can create challenges.
     *
     * @param  \App\User $user
     * @param Challenge $challenge
     * @return bool
     */
    public function create(User $user, Challenge $challenge)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','challenges')->where('create',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given challenge can be edited by the user.
     *
     * @param  \App\User $user
     * @param Challenge $challenge
     * @return bool
     */
    public function edit(User $user, Challenge $challenge)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','challenges')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the given challenge can be deleted by the user.
     *
     * @param  \App\User $user
     * @param Challenge $challenge
     * @return bool
     */
    public function destroy(User $user, Challenge $challenge)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','challenges')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
