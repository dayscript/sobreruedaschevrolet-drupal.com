<?php

namespace App\Http\Controllers\Challenges;

use App\Manager\Challenges\Goal;
use App\Manager\Programs\Channel;
use App\Manager\User\Goalvalue;
use App\Manager\User\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function goals(Request $request)
    {
        $useddates = Goalvalue::getUsedDates();
        $goals = Goal::where('active',true)->orderBy('name')->get();
        $supervisors = Role::find(3)->users()->orderBy('firstname')->get();
        $channels = Channel::orderBy('name')->get();
        $date = $request->get('date', $useddates->last());
        $goal = $request->get('goal', '');
        $supervisor = $request->get('supervisor', '');
        $channel = $request->get('channel', '');
        $values = Goalvalue::whereHas('goal',function ($query){
            $query->where('active',true);
        });
        if($date)$values = $values->where('period',$date);
        if($goal)$values = $values->where('goal_id',$goal);
        if($supervisor)$values = $values->whereHas('user',function ($query) use ($supervisor) {
            $query->where('parent_id', $supervisor);
        });
        if($channel)$values = $values->whereHas('goal.challenge.channels',function ($query) use ($channel) {
            $query->where('id', $channel);
        });

        $values = $values->paginate(20);
        return view('reports.goals', compact('values','date','goal','goals','supervisors','supervisor','channels','channel'));
    }
    public function goalsexport(Request $request)
    {
        $useddates = Goalvalue::getUsedDates();
        $goals = Goal::all();
        $supervisors = Role::find(3)->users;
        $channels = Channel::all();
        $date = $request->get('date', $useddates->last());
        $goal = $request->get('goal', '');
        $supervisor = $request->get('supervisor', '');
        $channel = $request->get('channel', '');
        $values = Goalvalue::has('goal');
        if($date)$values = $values->where('period',$date);
        if($goal)$values = $values->where('goal_id',$goal);
        if($supervisor)$values = $values->whereHas('user',function ($query) use ($supervisor) {
            $query->where('parent_id', $supervisor);
        });
        if($channel)$values = $values->whereHas('goal.challenge.channels',function ($query) use ($channel) {
            $query->where('id', $channel);
        });

        $values = $values->get();

        Excel::create('GoalsExport-'.time(), function ($excel) use ($values) {
            $excel->setTitle('');
            $excel->setCreator('Sodexo')->setCompany('Sodexo');
            $excel->setDescription('Reporte');
            $excel->sheet('Metas', function ($sheet) use ($values) {
                $sheet->loadView('reports.goalsexport')
                    ->with('values', $values);
            });
        })
            ->download('xls')
        ;
//        return view('reports.goalsexport', compact('goals','date'));
    }
}
