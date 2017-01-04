<?php

namespace App\Manager\User;

use Illuminate\Database\Eloquent\Model;

class ImportTemplate extends Model
{
    protected $table = 'import_templates';
    protected $fillable = ['name'];

    /**
     * Channels for this template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->belongsToMany('App\Manager\Programs\Channel','import_template_channel');
    }
    /**
     * Roles for this template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Manager\User\Role','import_template_role');
    }
    /**
     * Vars for this template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variables()
    {
        return $this->belongsToMany('App\Manager\Challenges\Variable','import_template_variable');
    }
}
