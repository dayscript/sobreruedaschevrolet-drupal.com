<?php

namespace App\Http\Controllers\Utils;

use App\Manager\Challenges\Challenge;
use App\Manager\Programs\Channel;
use App\User;
use App\Http\Requests;
use App\Manager\User\Role;
use Illuminate\Http\Request;
use App\Manager\Programs\Program;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    /**
     * Lists all programs
     * GET /programs
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function programs()
    {
        $programs = Program::all();
        return $programs;
    }

    /**
     * Lists all system users with the basic properties.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        $data = collect([]);
        $users = User::all();
//        $users = User::with('roles')->get();
        foreach ($users as $user){
            $row = [];
            $attributes = [
                'guid',
                'id',
                'identification',
                'email',
                'firstname',
                'lastname',
                'mobile',
                'password',
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
                'status',
                'created_at',
                'updated_at',
            ];
            foreach ($attributes as $att){
                if ($user->$att == '')$user->$att = null;
                $row[$att] = $user->$att;
            }
            if($user->roles() && ($role = $user->roles()->first())){
                $row['role'] = $role->name;
            } else {
                $row['role'] = null;
            }
            if($user->channels() && ($channel = $user->channels()->first())){
                $row['channel'] = $channel->name;
            } else {
                $row['channel'] = null;
            }
            if($user->parent_id &&($parent = $user->parent)){
                $row['parent1'] = 'user_'.$parent->id;
                if($parent->parent_id &&($parent2 = $parent->parent)){
                    $row['parent2'] = 'user_'.$parent2->id;
                    if($parent2->parent_id &&($parent3 = $parent2->parent)){
                        $row['parent3'] = 'user_'.$parent3->id;
                    } else{
                        $row['parent3'] = null;
                    }
                } else {
                    $row['parent2'] = null;
                    $row['parent3'] = null;
                }
            } else {
                $row['parent1'] = null;
                $row['parent2'] = null;
                $row['parent3'] = null;
            }

            $row['distribuitor'] = null;
            $row['mechanic'] = null;

//            $data = $data->push($user);
            $data = $data->push($row);
        }
        return $data;
    }

    /**
     * Lists all roles
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function roles()
    {
        return Role::all();
    }

    /**
     * Lists all challenges
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function challenges()
    {
        return Challenge::all();
    }

    /**
     * Lists all channels
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function channels()
    {
        return Channel::all();
    }
}
