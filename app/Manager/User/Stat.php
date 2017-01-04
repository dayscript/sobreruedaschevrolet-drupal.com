<?php

namespace App\Manager\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'action',
        'value',
        'user_id',
        'model_id',
        'model_type',
        'ip',
    ];
    /**
     * User of this record
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    /**
     * Get all of the owning models.
     */
    public function model()
    {
        return $this->morphTo();
    }
    /**
     * Returns formatted creation date
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute( $date )
    {
        setlocale(LC_ALL, 'es_ES');
        return Carbon::parse($date)->formatLocalized('%B %e, %G - %l:%M %p');
    }

    /**
     * Returns label string based on action
     * @param $gender
     * @return string
     */
    public function label()
    {
        if ($this->action == 'userview'){
            return 'vió un perfil de usuario';
        }elseif($this->action=='users'){
            return 'vió listado de usuarios';
        }elseif($this->action=='usersbyprogram'){
            return 'vió usuarios de un programa';
        }elseif($this->action=='userrestore'){
            return 'restauró un usuario';
        }elseif($this->action=='userdestroy'){
            return 'eliminó un usuario';
        }elseif($this->action=='userupdate'){
            return 'actualizó un usuario';
        }elseif($this->action=='useredit'){
            return 'entró a editar un usuario';
        }elseif($this->action=='userssearch'){
            return 'buscó usuarios';
        }elseif($this->action=='roles'){
            return 'vió listado de roles';
        }elseif($this->action=='rolessearch'){
            return 'buscó roles';
        }elseif($this->action=='programs'){
            return 'vió listado de programas';
        }elseif($this->action=='programedit'){
            return 'editó un programa';
        }elseif($this->action=='programupdate'){
            return 'actualizó un programa';
        }elseif($this->action=='permissions'){
            return 'vió listado de permisos';
        }elseif($this->action=='permissionssearch'){
            return 'buscó permisos';
        }elseif($this->action=='dashboard'){
            return 'visitó el Dashboard';
        }elseif($this->action=='login'){
            return 'ingresó al sistema';
        }elseif($this->action=='logout'){
            return 'salió del sistema';
        }
        return $this->action;
    }
    public function description()
    {
        if($this->action=='profileupdate') {
            return '<small>' . $this->created_at . '</small><br> Actualización del perfil';
        }elseif($this->action=='dashboard'){
            return 'Visualización del Dashboard de la aplicación';
        }elseif($this->action=='login'){
            return 'Inicio de sesión en el sistema desde la dirección IP: <a><em>'.$this->ip . '</em></a>';
        }elseif($this->action=='logout'){
            return 'Sesión en el sistema cerrada desde la dirección IP: <a><em>'.$this->ip . '</em></a>';
        }
        return  $this->value;
    }
}
