<?php

namespace App\Http\Controllers\Challenges;

use App\Http\Requests;
use App\Manager\User\Role;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Manager\Challenges\Goal;
use App\Manager\Programs\Program;
use App\Http\Controllers\Controller;
use App\Manager\Challenges\Challenge;
use Illuminate\Support\Facades\Validator;

class GoalsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $option
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $option = "all")
    {
        if ($this->user->cannot('list', new Goal)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $active = $request->get('active', 1);
        $search = $request->get('search', '');
        if ($option == "trashed") {
            if ($search)
                $goals = Goal::onlyTrashed()->where('active',$active)->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
            else $goals = Goal::onlyTrashed()->where('active',$active)->orderBy('name')->paginate(20);
        } else {
            if ($search)
                $goals = Goal::where('name', 'like', '%' . $search . '%')->where('active',$active)->orderBy('name')->paginate(20);
            else $goals = Goal::orderBy('name')->where('active',$active)->paginate(20);
        }
        $programs = $this->user->programs;
        $challenges = $this->user->challenges();
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goalssearch', 'value' => 'Búsqueda de metas: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goals', 'value' => 'Ver listado de metas']);
        return view('goals.index', compact('goals', 'option', 'programs','challenges', 'search','active'));
    }

    /**
     * Lists goals by program
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function byProgram(Request $request, Program $program)
    {
        if ($this->user->cannot('listByProgram', [new Goal, $program])) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $option = "program";
        $active = $request->get('active', 1);
        $search = $request->get('search', '');
        if ($search)
            $goals = $program->goals()->where('active',$active)->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
        else
            $goals = $program->goals()->where('active',$active)->orderBy('name')->paginate(20);
        $programs = $this->user->programs;
        $challenges = $this->user->challenges();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goalsbyprogram', 'value' => 'Ver listado de metas del programa: ' . $program->name]);
        return view('goals.index', compact('goals', 'option', 'programs', 'challenges', 'program', 'search','active'));
    }

    /**
     * Displays goals filtered by the given type
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function byType(Request $request, $type)
    {
        $option = "type";
        $active = $request->get('active', 1);
        $search = $request->get('search', '');
        $programs = $this->user->programs;
        $challenges = $this->user->challenges();
        if($search)
            $goals = Goal::where('type',$type)->where('active',$active)->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
        else
            $goals = Goal::where('type',$type)->where('active',$active)->orderBy('name')->paginate(20);

        return view('goals.index', compact('goals', 'option', 'programs','challenges', 'search','active'));
    }
    /**
     * Lists trashed items
     * @param Request $request
     * @param string $option
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function trashed(Request $request, $option = 'list', $id = null)
    {
        if ($this->user->cannot('list', new Goal)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        if ($option == 'list')
            return $this->index($request, 'trashed');
        elseif ($option == 'delete')
            return $this->deltrashed($request, $id);
        elseif ($option == 'restore')
            return $this->restoretrashed($request, $id);
        else return $this->index($request, 'trashed');
    }

    /**
     * Permanently delete this record
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function deltrashed(Request $request, $id)
    {
        $gl = Goal::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $gl)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/goals');
            }
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goaldeltrashed', 'value' => 'Meta eliminada definitivamente:' . $gl->name . ' (ID:' . $gl->id . ')', 'model_id' => $gl->id, 'model_type' => get_class($gl)]);
        $gl->forceDelete();
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Meta eliminada!');
            return redirect('/goals');
        }
    }

    /**
     * Restores selected record
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function restoretrashed(Request $request, $id)
    {
        $gl = Goal::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $gl)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/goals');
            }
        }

        $gl->restore();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goalrestore', 'value' => 'Meta restaurada: <a href="/goals/' . $gl->id . '"><em>' . $gl->name . ' (ID:' . $gl->id . ')</em></a>', 'model_id' => $gl->id, 'model_type' => get_class($gl)]);
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Meta restaurada!');
            return redirect('/goals');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->user->cannot('create', new Goal)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/goals');
        }

        $validationmessages = [
            'name.required' => 'El nombre de la meta es requerido!',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $validationmessages);
        if ($validator->fails()) {
            //            dd($validator->errors()->messages());
            $messages = $validator->errors();
            $message = '';
            foreach ($messages->all('<li>:message</li>') as $msg) {
                $message .= $msg;
            }
            Flash::error($message);
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $goal = Goal::create($data);
        if($ch = Challenge::findOrFail($request->get('challenge'))){
            $goal->challenge()->associate($ch);
            $goal->save();
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goalcreate', 'value' => 'Meta creada: <a href="/goals/' . $goal->id . '"><em>' . $goal->name . ' (ID:' . $goal->id . ')</em></a>', 'model_id' => $goal->id, 'model_type' => get_class($goal)]);
        Flash::success('Meta creada!');
        return redirect('/goals');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Goal $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Goal $goal)
    {
        if ($this->user->cannot('show', $goal)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/goals');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goalview', 'value' => 'Meta vista: ' . $goal->id, 'model_id' => $goal->id, 'model_type' => get_class($goal)]);
        return view('goals.show', compact('goal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Goal $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Goal $goal)
    {
        if ($this->user->cannot('edit', $goal)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/goals');
        }
        $programs = $this->user->programs;
        $challenges = $this->user->challenges();
        $roles = Role::all();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goaledit', 'value' => 'Editando meta: <a href="/goals/' . $goal->id . '"><em>' . $goal->name . ' (ID:' . $goal->id . ')</em></a>', 'model_id' => $goal->id, 'model_type' => get_class($goal)]);
        return view('goals.edit', compact('goal', 'programs','challenges','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Goal $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        if ($this->user->cannot('edit', $goal)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/goals');
            }
        }
        $data = $request->all();
        if (isset($data['variable1_id']))
            $data['variable1_id'] = str_replace(')', '', substr($data['variable1_id'], strpos($data['variable1_id'], '(ID:') + 4));
        if ($data['variable1_id'] == '')
            unset($data['variable1_id']);
        if (isset($data['variable2_id']))
            $data['variable2_id'] = str_replace(')', '', substr($data['variable2_id'], strpos($data['variable2_id'], '(ID:') + 4));
        if ($data['variable2_id'] == '')
            unset($data['variable2_id']);
        if (isset($data['points_variable']))
            $data['points_variable'] = str_replace(')', '', substr($data['points_variable'], strpos($data['points_variable'], '(ID:') + 4));
        if ($data['points_variable'] == '')
            unset($data['points_variable']);
        $data['active'] = $request->get('active',0);
        $goal->update($data);
        $goal->goals()->sync($request->get('goals', []));
        if($ch = Challenge::findOrFail($request->get('challenge'))){
            $goal->challenge()->associate($ch);
            $goal->save();
        }
        if($rl = Role::findOrFail($request->get('rol'))){
            $goal->role()->associate($rl);
            $goal->save();
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goalupdate', 'value' => 'Meta actualizada: <a href="/goals/' . $goal->id . '"><em>' . $goal->name . ' (ID:' . $goal->id . ')</em></a>', 'model_id' => $goal->id, 'model_type' => get_class($goal)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Meta actualizada!');
            return redirect('/goals');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Goal $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Goal $goal)
    {
        if ($this->user->cannot('destroy', $goal)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/goals');
            }
        }
        $goal->delete();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'goaldestroy', 'value' => 'Meta eliminada: ' . $goal->name . ' (ID:' . $goal->id . ')', 'model_id' => $goal->id, 'model_type' => get_class($goal)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Meta eliminada!');
            return redirect('/goals');
        }
    }
}
