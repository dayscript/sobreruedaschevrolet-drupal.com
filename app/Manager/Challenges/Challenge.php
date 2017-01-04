<?php

namespace App\Manager\Challenges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Challenge extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','program_id'];
    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
        return 'challenge_'.$this->id;
    }
    /**
     * Get the program that owns this record.
     */
    public function program()
    {
        return $this->belongsTo('App\Manager\Programs\Program');
    }
    /**
     * Goals in this challenge
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany('App\Manager\Challenges\Goal');
    }
    /**
     * Channels for this challenge
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->belongsToMany('App\Manager\Programs\Channel')->withTimestamps();
    }
    
}
