<?php

namespace App\Manager\Programs;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['field', 'value', 'program_id','slug'];
    /**
     * The database table for this model
     *
     * @var string
     */
    protected $table = 'program_fields';
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
}
