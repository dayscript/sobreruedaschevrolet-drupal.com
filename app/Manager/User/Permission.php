<?php

namespace App\Manager\User;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'model', 'list', 'show', 'create', 'edit', 'destroy'
    ];

    public static function getOptions()
    {
        return [
            'list'    => 'Listar',
            'show'    => 'Ver detalle',
            'create'  => 'Crear',
            'edit'    => 'Editar',
            'destroy' => 'Eliminar',
        ];
    }

    public static function getModels()
    {
        return [
            'programs'         => 'Programas',
            'users'            => 'Usuarios',
            'roles'            => 'Roles',
            'permissions'      => 'Permisos',
            'challenges'       => 'Desafíos',
            'variables'        => 'Variables del programa',
            'goals'            => 'Metas',
            'import_templates' => 'Plantillas de carga',
            'user_goals'       => 'Liquidación de metas de usuarios',
        ];
    }

    /**
     * Roles for this Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Manager\User\Role')->withTimestamps();
    }
}
