<?php

namespace App\Manager\Programs;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Program extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'url', 'start', 'end', 'pointsname', 'pointsvalue',
        'client',
        'pointslimit',
        'userslimit',
        'terms',
    ];

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'start', 'end'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['guid'];

    public static function getFields()
    {
        return [
            'identification' => 'Cédula',
            'firstname'      => 'Nombre propio',
            'lastname'       => 'Apellidos',
            'email'          => 'Email',
            'address'        => 'Dirección',
            'address2'       => 'Dirección 2',
            'phone'          => 'Teléfono',
            'mobile'         => 'Celular',
            'fax'            => 'Fax',
            'city'           => 'Ciudad',
            'country'        => 'Pais',
            'birth'          => 'Fecha de nacimiento',
            'gender'         => 'Género',
            'status'         => 'Estado',
            'parent_id'      => 'Jefe',
        ];
    }

    /**
     * Returns formatted creation date
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        setlocale(LC_ALL, 'es_ES');
        return Carbon::parse($date)->formatLocalized('%B %e, %G - %l:%M %p');
    }

    /**
     * Returns GUID Attribute for Drupal importing
     * @return string
     */
    public function getGuidAttribute()
    {
        return 'program_'.$this->id;
    }
    /**
     * Users in this project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * Roles in this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Manager\User\Role')->withTimestamps();
    }
    /**
     * Fields in this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany('App\Manager\Programs\Field');
    }
    /**
     * Channels in this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->hasMany('App\Manager\Programs\Channel');
    }
    /**
     * Challenges in this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challenges()
    {
        return $this->hasMany('App\Manager\Challenges\Challenge');
    }
    /**
     * Variables in this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variables()
    {
        return $this->hasMany('App\Manager\Challenges\Variable');
    }
    /**
     * Goals in this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasManyThrough('App\Manager\Challenges\Goal','App\Manager\Challenges\Challenge');
    }

}
