<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests;
use App\Manager\Challenges\Variable;
use App\Manager\Programs\Channel;
use App\Manager\User\ImportTemplate;
use App\Manager\User\Role;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Manager\User\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportTemplatesController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->user->cannot('list', new ImportTemplate)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $search = $request->get('search', '');
        $roles = Role::all();
        $channels = Channel::all();
        if ($search)
            $templates = ImportTemplate::latest()->where('name', 'like', '%' . $search . '%')->paginate(20);
        else $templates = ImportTemplate::latest()->paginate(20);
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templatessearch', 'value' => 'Búsqueda de pantillas: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templates', 'value' => 'Ver listado de plantillas']);
        return view('templates.index', compact('templates', 'roles', 'channels', 'search'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->user->cannot('create', new ImportTemplate())) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/import_templates');
        }

        $validationmessages = [
            'name.required' => 'El nombre de la plantilla es requerido!',
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
        $template = ImportTemplate::create($request->all());
        $template->roles()->sync($request->get('roles', []));
        $template->channels()->sync($request->get('channels', []));
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templatecreate', 'value' => 'Plantilla creada: <a href="/import_templates/' . $template->id . '"><em>' . $template->name . ' (ID:' . $template->id . ')</em></a>', 'model_id' => $template->id, 'model_type' => get_class($template)]);
        Flash::success('Plantilla creada!');
        return redirect('/import_templates');
    }

    /**
     * Download the specified resource.
     *
     * @param Request $request
     * @param ImportTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, ImportTemplate $template)
    {
        if ($this->user->cannot('show', $template)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/import_templates');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templatedownload', 'value' => 'Plantilla descargada: ' . $template->id, 'model_id' => $template->id, 'model_type' => get_class($template)]);
        $date = $request->get('date',date('Y-m'));
        Excel::create('ImportTemplate-' . $template->id . '-'.time(), function ($excel) use ($template,$date) {
            $excel->setTitle($template->name);
            $excel->setCreator('Sodexo')->setCompany('Sodexo');
            $excel->setDescription('Plantilla para cargar información al sistema de liquidaciones de Sodexo');
            $excel->sheet('Datos', function ($sheet) use ($template,$date) {
                $sheet->loadView('templates.download')
                    ->with('template', $template)
                    ->with('date', $date);
            });
        })
                        ->download('xls')
        ;
//        return view('templates.download', compact('template', 'date'));
    }
    /**
     * Download the users create template
     *
     * @param Request $request
     * @param ImportTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function usersdownload(Request $request)
    {
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userstemplatedownload', 'value' => 'Plantilla de usuarios descargada']);
        Excel::create('UsersImportTemplate-'.time(), function ($excel) {
            $excel->setTitle('Carga de usuarios');
            $excel->setCreator('Sodexo')->setCompany('Sodexo');
            $excel->setDescription('Plantilla para cargar usuarios al sistema de liquidaciones de Sodexo');
            $excel->sheet('Usuarios', function ($sheet) {
                $sheet->loadView('templates.usersdownload');
            });
        })
            ->download('xls')
        ;
//                return view('templates.usersdownload');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param ImportTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ImportTemplate $template)
    {
        if ($this->user->cannot('show', $template)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/import_templates');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templateview', 'value' => 'Plantilla vista: ' . $template->id, 'model_id' => $template->id, 'model_type' => get_class($template)]);
        return view('templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param ImportTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ImportTemplate $template)
    {
        if ($this->user->cannot('edit', $template)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/import_templates');
        }
        $roles = Role::all();
        $channels = Channel::all();
        $variables = Variable::where('type', 'simple')->orderBy('name')->get();
        $challenges = [];
        foreach ($variables as $variable) {
            $goals = $variable->goals();
            foreach ($goals as $goal) {
                if(!isset($challenges[$goal->challenge_id])){
                    $challenges[$goal->challenge_id] = ['challenge'=>$goal->challenge,'variables'=>[]];
                }
                $challenges[$goal->challenge_id]['variables'][$variable->id] = $variable;
            }
        }

        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templateedit', 'value' => 'Editando plantilla: <a href="/import_templates/' . $template->id . '"><em>' . $template->name . ' (ID:' . $template->id . ')</em></a>', 'model_id' => $template->id, 'model_type' => get_class($template)]);
        return view('templates.edit', compact('template', 'roles', 'variables', 'channels', 'challenges'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ImportTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImportTemplate $template)
    {
        if ($this->user->cannot('edit', $template)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/import_templates');
            }
        }
        $template->update($request->all());
        $template->channels()->sync($request->get('channels', []));
        $template->roles()->sync($request->get('roles', []));
        $template->variables()->sync($request->get('variables', []));

        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templateupdate', 'value' => 'Plantilla actualizada: <a href="/import_templates/' . $template->id . '"><em>' . $template->name . ' (ID:' . $template->id . ')</em></a>', 'model_id' => $template->id, 'model_type' => get_class($template)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Plantilla actualizada!');
            return redirect('/import_templates');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param ImportTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ImportTemplate $template)
    {
        if ($this->user->cannot('destroy', $template)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/import_templates');
            }
        }
        $template->delete();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'templatedestroy', 'value' => 'Plantilla eliminada: ' . $template->name . ' (ID:' . $template->id . ')', 'model_id' => $template->id, 'model_type' => get_class($template)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Plantilla eliminada!');
            return redirect('/import_templates');
        }
    }
}
