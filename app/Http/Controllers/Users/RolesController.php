<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Manager\User\Role;
use Illuminate\Http\Request;
use App\Manager\User\Permission;
use App\Manager\Programs\Program;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
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
        if ($this->user->cannot('list', new Role)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $search = $request->get('search', '');
        if ($option == "trashed") {
            if ($search)
                $roles = Role::onlyTrashed()->where('name', 'like', '%' . $search . '%')->paginate(20);
            else $roles = Role::onlyTrashed()->paginate(20);
        } else {
            if ($search)
                $roles = Role::latest()->where('name', 'like', '%' . $search . '%')->paginate(20);
            else $roles = Role::latest()->paginate(20);
        }
        $programs = $this->user->programs;
        $permissions = Permission::all();
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'rolessearch', 'value' => 'Búsqueda de roles: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'roles', 'value' => 'Ver listado de roles']);
        return view('roles.index', compact('roles', 'option', 'programs', 'search','permissions'));

    }

    public function byProgram(Request $request, Program $program)
    {
        if ($this->user->cannot('listByProgram', [new Role, $program])) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $option = "program";
        $search = $request->get('search', '');
        if ($search)
            $roles = $program->roles()->where('name', 'like', '%' . $search . '%')->paginate(20);
        else $roles = $program->roles()->paginate(20);
        $programs = $this->user->programs;
        $permissions = Permission::all();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'rolesbyprogram', 'value' => 'Ver listado de roles del programa: ' . $program->name]);
        return view('roles.index', compact('roles', 'option', 'programs', 'program', 'search','permissions'));

    }

    public function trashed(Request $request, $option = 'list', $id = null)
    {
        if ($this->user->cannot('list', new Role)) {
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

    public function deltrashed(Request $request, $id)
    {
        $rl = Role::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $rl)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/roles');
            }
        }

        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'roledeltrashed', 'value' => 'Rol eliminado definitivamente:' . $rl->name . ' (ID:' . $rl->id . ')', 'model_id' => $rl->id, 'model_type' => get_class($rl)]);
        $rl->forceDelete();
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Rol eliminado!');
            return redirect('/roles');
        }
    }

    public function restoretrashed(Request $request, $id)
    {
        $rl = Role::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $rl)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/roles');
            }
        }

        $rl->restore();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'rolerestore', 'value' => 'Rol restaurado: <a href="/roles/' . $rl->id . '"><em>' . $rl->name . ' (ID:' . $rl->id . ')</em></a>', 'model_id' => $rl->id, 'model_type' => get_class($rl)]);
        if($request->ajax()){
            return "ok";
        } else {
            Flash::success('Rol restaurado!');
            return redirect('/roles');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->user->cannot('create', new Role)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/roles');
        }

        $validationmessages = [
            'name.required' => 'El nombre del rol es requerido!',
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
        $role = Role::create($request->all());
        $role->programs()->sync($request->get('programs', []));
        $role->permissions()->sync($request->get('permissions', []));
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'rolecreate', 'value' => 'Rol creado: <a href="/roles/' . $role->id . '"><em>' . $role->name . ' (ID:' . $role->id . ')</em></a>', 'model_id' => $role->id, 'model_type' => get_class($role)]);
        Flash::success('Rol creado!');
        return redirect('/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        if ($this->user->cannot('show', $role)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/roles');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'roleview', 'value' => 'Rol visto: ' . $role->id, 'model_id' => $role->id, 'model_type' => get_class($role)]);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        if ($this->user->cannot('edit', $role)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/roles');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'roleedit', 'value' => 'Editando rol: <a href="/roles/' . $role->id . '"><em>' . $role->name . ' (ID:' . $role->id . ')</em></a>', 'model_id' => $role->id, 'model_type' => get_class($role)]);
        $programs = $this->user->programs;
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'programs','permissions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if ($this->user->cannot('edit', $role)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/roles');
            }
        }
        $role->update($request->all());
        $role->programs()->sync($request->get('programs', []));
        $role->permissions()->sync($request->get('permissions', []));
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'roleupdate', 'value' => 'Rol actualizado: <a href="/roles/' . $role->id . '"><em>' . $role->name . ' (ID:' . $role->id . ')</em></a>', 'model_id' => $role->id, 'model_type' => get_class($role)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Rol actualizado!');
            return redirect('/roles');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Role $role)
    {
        if ($this->user->cannot('destroy', $role)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/roles');
            }
        }
        $role->delete();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'roledestroy', 'value' => 'Rol eliminado: ' . $role->name . ' (ID:' . $role->id . ')', 'model_id' => $role->id, 'model_type' => get_class($role)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Rol eliminado!');
            return redirect('/roles');
        }
    }
}
