<?php

namespace App\Manager\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goalvalue extends Model
{
    /**
     * The database table for this model
     *
     * @var string
     */
    protected $table = 'user_goals';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['period', 'user_id', 'goal_id', 'value', 'points'];
    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'period'];

    /**
     * Return user owner of this value
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Return variable associated to this value
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goal()
    {
        return $this->belongsTo('App\Manager\Challenges\Goal');
    }
    /**
     * Returns formatted period date
     * @param $date
     * @return string
     */
    public function getPeriodAttribute( $date )
    {
//        setlocale(LC_ALL, 'es_ES');
//        return ucwords(Carbon::parse($date)->formatLocalized('%B %G'));
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Get available dates
     */
    public static function getUsedDates()
    {
        $dates = collect([]);
        $values = DB::table('user_goals')->select('period')->distinct()->get();
        foreach ($values as $value){
            $dates->push($value->period);
        }
        return $dates;
    }

}
