<?php

namespace App\Policies;

use App\User;
use App\Manager\User\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
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
     * @param Permission $permission
     * @return bool
     */
    public function list(User $user, Permission $permission)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','permissions')->where('list',1)->first())
                return true;
        }
        return false;
    }
    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param Permission $permission
     * @return bool
     */
    public function show(User $user, Permission $permission)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','permissions')->where('show',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can create records
     *
     * @param  \App\User $user
     * @param Permission $permission
     * @return bool
     */
    public function create(User $user, Permission $permission)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','permissions')->where('create',1)->first())
                return true;
        }
        return false;
    }
    /**
     * Determine if the user can edit records
     *
     * @param  \App\User $user
     * @param Permission $permission
     * @return bool
     */
    public function edit(User $user, Permission $permission)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','permissions')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can destroy records
     *
     * @param  \App\User $user
     * @param Permission $permission
     * @return bool
     */
    public function destroy(User $user, Permission $permission)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','permissions')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
