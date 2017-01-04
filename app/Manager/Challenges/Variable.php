<?php

namespace App\Manager\Challenges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variable extends Model
{
    use SoftDeletes;
    /**
     * The database table for this model
     *
     * @var string
     */
    protected $table = 'program_variables';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'program_id', 'slug', 'type', 'constant_value',
        'variable1_id',
        'variable2_id',
    ];

    /**
     * Returns an array with the list of possible variable types
     * @return array
     */
    public static function getTypes()
    {
        return [
            'constant'        => 'Constante',
            'simple'          => 'Variable simple',
            'multiply'        => 'Multiplicar dos variables',
            'percentage'      => 'Porcentaje calculado',
            'simpleincrement' => 'Incremento de una variable con el periodo anterior (%)',
        ];
    }

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['program'];

    /**
     * Get the program that owns this record.
     */
    public function program()
    {
        return $this->belongsTo('App\Manager\Programs\Program');
    }

    /**
     * Returns appropiate label for the variable type
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
     * Get the associated first variable
     */
    public function variable1()
    {
        return $this->belongsTo('App\Manager\Challenges\Variable');
    }

    /**
     * Get the associated second variable
     */
    public function variable2()
    {
        return $this->belongsTo('App\Manager\Challenges\Variable');
    }

    public function goals()
    {
        $goals = $this->hasMany('App\Manager\Challenges\Goal', 'variable1_id')->get();
        $goals = $goals->merge($this->hasMany('App\Manager\Challenges\Goal', 'variable2_id')->get());
        $goals = $goals->merge($this->hasManyThrough('App\Manager\Challenges\Goal', 'App\Manager\Challenges\Variable', 'variable1_id', 'variable1_id')->get());
        $goals = $goals->merge($this->hasManyThrough('App\Manager\Challenges\Goal', 'App\Manager\Challenges\Variable', 'variable1_id', 'variable2_id')->get());
        $goals = $goals->merge($this->hasManyThrough('App\Manager\Challenges\Goal', 'App\Manager\Challenges\Variable', 'variable2_id', 'variable1_id')->get());
        $goals = $goals->merge($this->hasManyThrough('App\Manager\Challenges\Goal', 'App\Manager\Challenges\Variable', 'variable2_id', 'variable2_id')->get());
        return $goals;
    }
}
