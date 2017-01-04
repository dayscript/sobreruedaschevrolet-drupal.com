<?php

namespace App;

use App\Manager\User\Goalvalue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'identification',
        'email',
        'password',
        'mobile',
        'fax',
        'phone',
        'city',
        'country',
        'address',
        'address2',
        'lang',
        'birth',
        'hire',
        'retirement',
        'gender',
        'avatar',
        'parent_id',
        'status',
    ];

    /**
     * Lists possible statuses for a user
     * @return array
     */
    public static function statuses()
    {
        return [
            'active'    => 'Activo',
            'vacations' => 'Vacaciones',
            'license'   => 'Licencia',
            'inability' => 'Incapacidad',
            'down'      => 'De baja',
            ''      => '',
        ];
    }

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'birth', 'hire', 'retirement'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['guid'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
    /**
     * Returns GUID Attribute for Drupal importing
     * @return string
     */
    public function getGuidAttribute()
    {
        return 'user_'.$this->id;
    }

    /**
     * Return complete user name
     * @return string
     */
    public function getNameAttribute()
    {
        return trim($this->firstname . ' ' . $this->lastname);
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
     * Returns formatted update date
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        setlocale(LC_ALL, 'es_ES');
        return Carbon::parse($date)->formatLocalized('%B %e, %G - %l:%M %p');
    }

    /**
     * Returns gender set value or detected and saved
     * @param $gender
     * @return string
     */
    public function getGenderAttribute($gender)
    {
        if (!$gender) {
            $gender = $this->detectGender();
            $this->update(['gender' => $gender]);
        }
        return $gender;
    }

    /**
     * Returns user avatar image
     * @param $avatar
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (!$avatar) {
            if ($this->gender == 'female') {
                $avatar = '/images/users/female_' . rand(1, 18) . '.png';
            } else {
                $avatar = '/images/users/male_' . rand(1, 14) . '.png';
            }
            $this->update(['avatar' => $avatar]);
        }
        return $avatar;
    }


    /**
     * Returns possible gender based on name attribute using
     * Gender-Api service
     * @return string
     */
    function detectGender()
    {
        $myKey = 'VEeHoEhAeJqWQenAwg';
        $tokens = explode(' ', $this->name);
        $best_percentage = 0;
        $best_gender = 'unknown';
        foreach ($tokens as $token) {
            $data = json_decode(file_get_contents('https://gender-api.com/get?key=' . $myKey . '&name=' . urlencode($token)));
            if ($data->accuracy > 90)
                return $data->gender;
            if ($data->accuracy > $best_percentage) {
                $best_percentage = $data->accuracy;
                $best_gender = $data->gender;
            }
        }
        return $best_gender;
    }

    /**
     * Returns stats records
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stats()
    {
        return $this->hasMany('App\Manager\User\Stat')->orderBy('created_at', 'desc');
    }

    /**
     * Programs for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programs()
    {
        return $this->belongsToMany('App\Manager\Programs\Program')->withTimestamps();
    }

    /**
     * Challenges for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challenges()
    {
        $challenges = collect([]);
        foreach($this->programs as $program){
            $challenges = $challenges->merge($program->challenges);
        }
        return $challenges;
    }
    /**
     * Checks if the user is associated with given program
     * @param $program_id
     * @return bool
     */
    public function inProgram($program_id)
    {
        return $this->programs()->where('programs.id', $program_id)->first();
    }

    /**
     * Roles for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Manager\User\Role')->withTimestamps();
    }

    /**
     * Checks if the user belongs to the given role
     *
     * @param $role_id
     * @return boolean
     */
    public function hasRole($role_id)
    {
        return $this->roles()->where('roles.id', $role_id)->first();
    }

    /**
     * Return parent user in hierarchy
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Return users under this record in hierarchy
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'parent_id');
    }

    /**
     * Programs Agreements of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agreements()
    {
        return $this->belongsToMany('App\Manager\Programs\Program', 'user_agrees')->withTimestamps();
    }
    /**
     * Channels for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->belongsToMany('App\Manager\Programs\Channel')->withTimestamps();
    }

    /**
     * Return goal values for this record
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goalvalues()
    {
        return $this->hasMany('App\Manager\User\Goalvalue');
    }
    /**
     * Return values for this record
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany('App\Manager\User\Value');
    }

    /**
     * Gets Goal value for current user
     * @param $goal_id
     * @param $period
     * @return mixed
     */
    public function getGoalValue($goal_id, $period)
    {
        return Goalvalue::firstOrCreate(['period'=>$period,'goal_id'=>$goal_id,'user_id'=>$this->id]);
    }

    /**
     * Gets variable value for current user
     * @param $variable_id
     * @param $period
     * @return mixed
     */
    public function getVariableValue($variable_id, $period)
    {
        return Goalvalue::firstOrCreate(['period'=>$period,'goal_id'=>$goal_id,'user_id'=>$this->id]);
    }
}
