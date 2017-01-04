<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Manager\User\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
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
        if ($this->user->cannot('list', new Permission)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $search = $request->get('search', '');
        if ($search)
            $permissions = Permission::latest()->where('name', 'like', '%' . $search . '%')->paginate(20);
        else $permissions = Permission::latest()->paginate(20);
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissionssearch', 'value' => 'Búsqueda de permisos: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissions', 'value' => 'Ver listado de permisos']);
        return view('permissions.index', compact('permissions', 'search'));
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
        if ($this->user->cannot('create', new Permission)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/permissions');
        }

        $validationmessages = [
            'name.required' => 'El nombre del permiso es requerido!',
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
        $permission = Permission::create($request->all());
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissioncreate', 'value' => 'Permiso creado: <a href="/permissions/' . $permission->id . '"><em>' . $permission->name . ' (ID:' . $permission->id . ')</em></a>', 'model_id' => $permission->id, 'model_type' => get_class($permission)]);
        Flash::success('Permiso creado!');
        return redirect('/permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Permission $permission)
    {
        if ($this->user->cannot('show', $permission)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/permissions');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissionview', 'value' => 'Permiso visto: ' . $permission->id, 'model_id' => $permission->id, 'model_type' => get_class($permission)]);
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Permission $permission)
    {
        if ($this->user->cannot('edit', $permission)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/permissions');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissionedit', 'value' => 'Editando permiso: <a href="/permissions/' . $permission->id . '"><em>' . $permission->name . ' (ID:' . $permission->id . ')</em></a>', 'model_id' => $permission->id, 'model_type' => get_class($permission)]);
        return view('permissions.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if ($this->user->cannot('edit', $permission)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/permissions');
            }
        }
        $data = [
            'model'=>$request->get('model',''),
            'name'=>$request->get('name',''),
        ];
        foreach (Permission::getOptions() as $key => $option) {
            $data[$key] = $request->get($key,false);
        }
        $permission->update($data);
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissionupdate', 'value' => 'Permiso actualizado: <a href="/permissions/' . $permission->id . '"><em>' . $permission->name . ' (ID:' . $permission->id . ')</em></a>', 'model_id' => $permission->id, 'model_type' => get_class($permission)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Permiso actualizado!');
            return redirect('/permissions');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Permission $permission)
    {
        if ($this->user->cannot('destroy', $permission)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/permissions');
            }
        }
        $permission->delete();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'permissiondestroy', 'value' => 'Permiso eliminado: ' . $permission->name . ' (ID:' . $permission->id . ')', 'model_id' => $permission->id, 'model_type' => get_class($permission)]);
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Permiso eliminado!');
            return redirect('/permissions');
        }
    }
}
