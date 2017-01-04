<?php

namespace App\Manager\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['guid'];
    /**
     * Returns GUID Attribute for Drupal importing
     * @return string
     */
    public function getGuidAttribute()
    {
        return 'role_'.$this->id;
    }

    /**
     * Programs for this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programs()
    {
        return $this->belongsToMany( 'App\Manager\Programs\Program' )->withTimestamps();
    }
    /**
     * Users in this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany( 'App\User' )->withTimestamps();
    }
    /**
     * Permissions for this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->belongsToMany( 'App\Manager\User\Permission' )->withTimestamps();
    }

}
