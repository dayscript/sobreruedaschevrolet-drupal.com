<?php

namespace App\Http\Controllers\Challenges;

use App\Http\Requests;
use App\Manager\Programs\Channel;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Manager\Programs\Program;
use App\Http\Controllers\Controller;
use App\Manager\Challenges\Challenge;
use Illuminate\Support\Facades\Validator;

class ChallengesController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $option = 'all')
    {
        if ($this->user->cannot('list', new Challenge())) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $search = $request->get('search', '');
        if ($option == "trashed") {
            if ($search)
                $challenges = Challenge::onlyTrashed()->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
            else $challenges = Challenge::onlyTrashed()->orderBy('name')->paginate(20);
        } else {
            if ($search)
                $challenges = Challenge::where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
            else $challenges = Challenge::orderBy('name')->paginate(20);
        }
        $programs = $this->user->programs;
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengessearch', 'value' => 'Búsqueda de desafíos: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challenges', 'value' => 'Ver listado de desafíos']);
        return view('challenges.index', compact('challenges', 'option', 'programs', 'search'));
    }

    /**
     * Lists challenges by program
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function byProgram(Request $request, Program $program)
    {
        if ($this->user->cannot('listByProgram', [new Challenge, $program])) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $option = "program";
        $search = $request->get('search', '');
        if ($search)
            $challenges = $program->challenges()->where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(20);
        else $challenges = $program->challenges()->orderBy('name')->paginate(20);
        $programs = $this->user->programs;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengesbyprogram', 'value' => 'Ver listado de desafíos del programa: ' . $program->name]);
        return view('challenges.index', compact('challenges', 'option', 'programs', 'program', 'search'));
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
        if ($this->user->cannot('list', new Challenge)) {
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
        $ch = Challenge::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $ch)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/challenges');
            }
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengedeltrashed', 'value' => 'Desafío eliminado definitivamente:' . $ch->name . ' (ID:' . $ch->id . ')', 'model_id' => $ch->id, 'model_type' => get_class($ch)]);
        $ch->forceDelete();
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Desafío eliminado!');
            return redirect('/challenges');
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
        $ch = Challenge::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $ch)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/challenges');
            }
        }

        $ch->restore();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengerestore', 'value' => 'Desafío restaurado: <a href="/challenges/' . $ch->id . '"><em>' . $ch->name . ' (ID:' . $ch->id . ')</em></a>', 'model_id' => $ch->id, 'model_type' => get_class($ch)]);
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Desafío restaurado!');
            return redirect('/challenges');
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
        if ($this->user->cannot('create', new Challenge)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/challenges');
        }

        $validationmessages = [
            'name.required' => 'El nombre del desafío es requerido!',
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
        $challenge = Challenge::create($request->all());
        if($pr = Program::findOrFail($request->get('program'))){
            $challenge->program()->associate($pr);
            $challenge->save();
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengecreate', 'value' => 'Desafío creado: <a href="/challenges/' . $challenge->id . '"><em>' . $challenge->name . ' (ID:' . $challenge->id . ')</em></a>', 'model_id' => $challenge->id, 'model_type' => get_class($challenge)]);
        Flash::success('Desafío creado!');
        return redirect('/challenges');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Challenge $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Challenge $challenge)
    {
        if ($this->user->cannot('show', $challenge)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/challenges');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengeview', 'value' => 'Desafío visto: ' . $challenge->id, 'model_id' => $challenge->id, 'model_type' => get_class($challenge)]);
        return view('challenges.show', compact('challenge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Challenge $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Challenge $challenge)
    {
        if ($this->user->cannot('edit', $challenge)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/challenges');
        }
        if ($this->user->id == 1){
            $programs = Program::all();
            $channels = Channel::all();
        } else {
            $programs = $this->user->programs;
            $channels = $this->user->channels;
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengeedit', 'value' => 'Editando desafío: <a href="/challenges/' . $challenge->id . '"><em>' . $challenge->name . ' (ID:' . $challenge->id . ')</em></a>', 'model_id' => $challenge->id, 'model_type' => get_class($challenge)]);
        return view('challenges.edit', compact('challenge', 'programs','channels'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Challenge $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        if ($this->user->cannot('edit', $challenge)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/challenges');
            }
        }
        $challenge->update($request->all());
        $challenge->channels()->sync($request->get('channels', []));
        if($pr = Program::findOrFail($request->get('program'))){
            $challenge->program()->associate($pr);
            $challenge->save();
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengeupdate', 'value' => 'Desafío actualizado: <a href="/challenges/' . $challenge->id . '"><em>' . $challenge->name . ' (ID:' . $challenge->id . ')</em></a>', 'model_id' => $challenge->id, 'model_type' => get_class($challenge)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Desafío actualizado!');
            return redirect('/challenges');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Challenge $challenge
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Challenge $challenge)
    {
        if ($this->user->cannot('destroy', $challenge)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/challenges');
            }
        }
        $challenge->delete();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'challengedestroy', 'value' => 'Desafío eliminado: ' . $challenge->name . ' (ID:' . $challenge->id . ')', 'model_id' => $challenge->id, 'model_type' => get_class($challenge)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Desafío eliminado!');
            return redirect('/challenges');
        }
    }
}
