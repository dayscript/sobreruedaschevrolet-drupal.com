<?php

namespace App\Http\Controllers\Utils;

use App\Manager\Challenges\Variable;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Returns users matching the query string in the name field
     * @param string $query
     * @return array
     */
    public function users($query = '')
    {
        $users =  User::where('firstname','like','%'.$query.'%')->orWhere('lastname','like','%'.$query.'%')->take(10)->get();
        $data = [];
        foreach ($users as $us){
            $data[] = ['name'=>$us->name . ' (ID:'.$us->id .')'];
        }
        return $data;
    }
    /**
     * Returns variables matching the query string in the name or slug field
     * @param string $query
     * @return array
     */
    public function variables($query = '')
    {
        $variables =  Variable::where('name','like','%'.$query.'%')->orWhere('slug','like','%'.$query.'%')->take(10)->get();
        $data = [];
        foreach ($variables as $vr){
            $data[] = ['name'=>$vr->name . ' (ID:'.$vr->id .')'];
        }
        return $data;
    }
}
