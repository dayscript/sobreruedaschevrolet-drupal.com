<?php

namespace App\Policies;

use App\User;
use App\Manager\User\ImportTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImportTemplatePolicy
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
     * @param ImportTemplate $template
     * @return bool
     */
    public function list(User $user, ImportTemplate $template)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','import_templates')->where('list',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user view record details
     *
     * @param  \App\User $user
     * @param ImportTemplate $template
     * @return bool
     */
    public function show(User $user, ImportTemplate $template)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','import_templates')->where('show',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can create records
     *
     * @param  \App\User $user
     * @param ImportTemplate $template
     * @return bool
     */
    public function create(User $user, ImportTemplate $template)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','import_templates')->where('create',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can edit records
     *
     * @param  \App\User $user
     * @param ImportTemplate $template
     * @return bool
     */
    public function edit(User $user, ImportTemplate $template)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','import_templates')->where('edit',1)->first())
                return true;
        }
        return false;
    }

    /**
     * Determine if the user can destroy records
     *
     * @param  \App\User $user
     * @param ImportTemplate $template
     * @return bool
     */
    public function destroy(User $user, ImportTemplate $template)
    {
        foreach($user->roles as $role){
            if ($role->permissions->where('model','import_templates')->where('destroy',1)->first())
                return true;
        }
        return false;
    }
}
