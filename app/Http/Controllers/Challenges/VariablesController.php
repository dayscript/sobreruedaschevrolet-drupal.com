<?php

namespace App\Http\Controllers\Challenges;

use App\Manager\Challenges\Variable;
use App\Manager\Programs\Program;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class VariablesController extends Controller
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
        if ($this->user->cannot('list', new Variable)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $type = $request->get('type', '');
        $search = $request->get('search', '');
        if ($option == "trashed") {
            if ($search)
                $variables = Variable::onlyTrashed()->where('type','like','%'.$type.'%')->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
            else $variables = Variable::onlyTrashed()->where('type','like','%'.$type.'%')->orderBy('name')->paginate(20);
        } else {
            if ($search)
                $variables = Variable::where('type','like','%'.$type.'%')->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
            else $variables = Variable::where('type','like','%'.$type.'%')->orderBy('name')->paginate(20);
        }
        $programs = $this->user->programs;
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variablessearch', 'value' => 'Búsqueda de variables: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variables', 'value' => 'Ver listado de variables']);
        return view('variables.index', compact('variables', 'option', 'programs', 'search','type'));
    }

    /**
     * Lists variables by program
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function byProgram(Request $request, Program $program)
    {
        if ($this->user->cannot('listByProgram', [new Variable, $program])) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $option = "program";
        $type = $request->get('type', '');
        $search = $request->get('search', '');
        if ($search)
            $variables = $program->variables()->where('type','like','%'.$type.'%')->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
        else $variables = $program->variables()->where('type','like','%'.$type.'%')->orderBy('name')->paginate(20);
        $programs = $this->user->programs;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variablesbyprogram', 'value' => 'Ver listado de variables del programa: ' . $program->name]);
        return view('variables.index', compact('variables', 'option', 'programs', 'program', 'search','type'));
    }

    /**
     * Displays variables filtered by the given type
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function byType(Request $request, $type)
    {
        $option = "type";
//        $type = $request->get('type', '');
        $search = $request->get('search', '');
        $programs = $this->user->programs;
        $variables = Variable::where('type',$type)->orderBy('name')->paginate(20);

        return view('variables.index', compact('variables', 'option', 'programs', 'search','type'));
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
        if ($this->user->cannot('list', new Variable)) {
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
        $vr = Variable::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $vr)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/variables');
            }
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variabledeltrashed', 'value' => 'Variable eliminada definitivamente:' . $vr->name . ' (ID:' . $vr->id . ')', 'model_id' => $vr->id, 'model_type' => get_class($vr)]);
        $vr->forceDelete();
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Variable eliminada!');
            return redirect('/variables');
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
        $vr = Variable::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $vr)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/variables');
            }
        }

        $vr->restore();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variablerestore', 'value' => 'Variable restaurada: <a href="/variables/' . $vr->id . '"><em>' . $vr->name . ' (ID:' . $vr->id . ')</em></a>', 'model_id' => $vr->id, 'model_type' => get_class($vr)]);
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Variable restaurada!');
            return redirect('/variables');
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
        if ($this->user->cannot('create', new Variable)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/variables');
        }

        $validationmessages = [
            'name.required' => 'El nombre de la variable es requerido!',
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
        $data['slug'] = str_slug(trim($data['name']),'_');

        $variable = Variable::create($data);
        if($pr = Program::findOrFail($request->get('program'))){
            $variable->program()->associate($pr);
            $variable->save();
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variablecreate', 'value' => 'Variable creada: <a href="/variables/' . $variable->id . '"><em>' . $variable->name . ' (ID:' . $variable->id . ')</em></a>', 'model_id' => $variable->id, 'model_type' => get_class($variable)]);
        Flash::success('Variable creado!');
        return redirect('/variables');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Variable $variable)
    {
        if ($this->user->cannot('show', $variable)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/variables');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variableview', 'value' => 'Variable vista: ' . $variable->id, 'model_id' => $variable->id, 'model_type' => get_class($variable)]);
        return view('variables.show', compact('variable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Variable $variable)
    {
        if ($this->user->cannot('edit', $variable)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/variables');
        }
        $programs = $this->user->programs;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variableedit', 'value' => 'Editando variable: <a href="/variables/' . $variable->id . '"><em>' . $variable->name . ' (ID:' . $variable->id . ')</em></a>', 'model_id' => $variable->id, 'model_type' => get_class($variable)]);
        return view('variables.edit', compact('variable', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variable $variable)
    {
        if ($this->user->cannot('edit', $variable)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/variables');
            }
        }
        $data = $request->all();
        $data['slug'] = str_slug(trim($data['name']),'_');
        if (isset($data['variable1_id']))
            $data['variable1_id'] = str_replace(')', '', substr($data['variable1_id'], strpos($data['variable1_id'], '(ID:') + 4));
        if ($data['variable1_id'] == '')
            unset($data['variable1_id']);
        if (isset($data['variable2_id']))
            $data['variable2_id'] = str_replace(')', '', substr($data['variable2_id'], strpos($data['variable2_id'], '(ID:') + 4));
        if ($data['variable2_id'] == '')
            unset($data['variable2_id']);
        $variable->update($data);
        if($pr = Program::findOrFail($request->get('program'))){
            $variable->program()->associate($pr);
            $variable->save();
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variableupdate', 'value' => 'Variable actualizada: <a href="/variables/' . $variable->id . '"><em>' . $variable->name . ' (ID:' . $variable->id . ')</em></a>', 'model_id' => $variable->id, 'model_type' => get_class($variable)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Variable actualizada!');
            return redirect('/variables');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Variable $variable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Variable $variable)
    {
        if ($this->user->cannot('destroy', $variable)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/variables');
            }
        }
        $variable->delete();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'variabledestroy', 'value' => 'Variable eliminada: ' . $variable->name . ' (ID:' . $variable->id . ')', 'model_id' => $variable->id, 'model_type' => get_class($variable)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Variable eliminada!');
            return redirect('/variables');
        }
    }
}
