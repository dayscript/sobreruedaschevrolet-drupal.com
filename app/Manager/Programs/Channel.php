<?php

namespace App\Manager\Programs;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'program_id'];
    /**
     * The database table for this model
     *
     * @var string
     */
    protected $table = 'program_channels';
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['program'];
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
        return 'channel_'.$this->id;
    }
    /**
     * Get the program that owns this record.
     */
    public function program()
    {
        return $this->belongsTo('App\Manager\Programs\Program');
    }
    /**
     * Users for this channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    /**
     * Challenges for this channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challenges()
    {
        return $this->belongsToMany('App\Manager\Challenges\Challenge')->withTimestamps();
    }
}
