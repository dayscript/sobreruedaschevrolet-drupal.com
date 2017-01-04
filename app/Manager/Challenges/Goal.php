<?php

namespace App\Manager\Challenges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use SoftDeletes;
    /**
     * The database table for this model
     *
     * @var string
     */
    protected $table = 'challenge_goals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'type', 'challenge_id', 'variable1_id', 'variable2_id', 'role_id', 'operator',
        'group',
        'points',
        'points_variable',
        'composednumber',
        'percentage',
        'totalpercentage',
    ];
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['challenge'];

    /**
     * Gets possible values for Goals types
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            'compare'     => 'Comparar dos variables',
            'multiply'    => 'Multiplicar variables',
            'composed'    => 'Cumplir un número metas de una lista',
            'grouptotal'  => 'Porcentaje del acumulado grupal x variable',
            'grouptotal2' => 'Porcentaje del acumulado grupal x meta',
            //            'comparecalc'=>'Valores de cumplimiento calculados. Extraer un % de dos valores dados (ej: unidades vendidas / unidades meta) y compararlo con otro valor calculado (20% más de ventas que el mes pasado)',
            //            'comparecalc'  => 'Valores de cumplimiento calculados',
            //            'groupmix'=>'Metas mixtas por grupo de ventas. Para jefes de ventas, que todos o un % de los integrantes de un grupo hayan cumplido sus metas en un periodo',
            //            'groupmix'     => 'Metas mixtas por grupo de ventas',
            //            'periodmix'=>'Metas mixtas por periodo de ventas. Que un vendedor o grupo de ventas haya cumplido sus metas durante un numero X de periodos consecutivos',
            //            'periodmix'    => 'Metas mixtas por periodo de ventas',
        ];
    }

    /**
     * Returns a large description of the given goal type
     * @param $type
     * @return string
     */
    public static function getTypeDescription($type)
    {
        $descriptions = [
            'compare'      => 'Compara dos variables usando un operador y asigna un número fijo de puntos cuando se cumple la condición.',
            'multiply'     => 'Asigna puntos resultantes de la multiplicación de dos variables.',
            'composed' => 'Agrupa varias metas y valida el cumplimiento de un número de metas de la lista.',
            'grouptotal'   => 'Asigna un porcentaje de los puntos totales acumulados por los subalternos si un porcentaje de ellos cumplen la condición de variables',
            'grouptotal2'  => 'Asigna un porcentaje de los puntos totales acumulados por los subalternos si un porcentaje de ellos cumplen la meta',
        ];
        if (!isset($descriptions[$type]))
            return '';
        return $descriptions[$type];

    }

    /**
     * Gets possible operators for goals compare type
     *
     * @return array
     */
    public static function getOperators()
    {
        return [
            '>'  => '>',
            '='  => '=',
            '<'  => '<',
            '>=' => '>=',
            '<=' => '<=',
        ];
    }

    /**
     * Get the challenge that owns this record.
     */
    public function challenge()
    {
        return $this->belongsTo('App\Manager\Challenges\Challenge');
    }

    /**
     * Get the role associated this record.
     */
    public function role()
    {
        return $this->belongsTo('App\Manager\User\Role');
    }

    /**
     * Get the first variable in a 'compare' goal
     */
    public function variable1()
    {
        return $this->belongsTo('App\Manager\Challenges\Variable');
    }

    /**
     * Get the points variable
     */
    public function pointsVariable()
    {
        return $this->belongsTo('App\Manager\Challenges\Variable', 'points_variable');
    }

    /**
     * Get the second variable in a 'compare' goal
     */
    public function variable2()
    {
        return $this->belongsTo('App\Manager\Challenges\Variable');
    }

    /**
     * Returns appropiate label for the goal type
     * @return mixed|string
     */
    public function typeLabel()
    {
        $types = $this->getTypes();
        if ($this->type && isset($types[$this->type])) {
            return $types[$this->type];
        }
        return '';
    }

    /**
     * Subgoals in a composed Goal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->belongsToMany('App\Manager\Challenges\Goal', 'challenge_goal_goal', 'goal1_id', 'goal2_id');
    }
}
