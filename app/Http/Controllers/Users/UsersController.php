<?php

namespace App\Http\Controllers\Users;

use App\Manager\Challenges\Challenge;
use App\Manager\Challenges\Variable;
use App\Manager\Programs\Channel;
use App\Manager\User\Goalvalue;
use App\Manager\User\Value;
use App\User;
use App\Http\Requests;
use App\Manager\User\Role;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Manager\Programs\Program;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
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
    public function index(Request $request, $option = "all")
    {
        if ($this->user->cannot('list', new User)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }

        $search = $request->get('search', '');
        if ($option == "trashed") {
            if ($search)
                $users = User::onlyTrashed()
                    ->where('firstname', 'like', '%' . $search . '%')
                    ->OrWhere('lastname', 'like', '%' . $search . '%')
                    ->OrWhere('identification', 'like', '%' . $search . '%')
                    ->orderBy('firstname')
                    ->paginate(20);
            else $users = User::onlyTrashed()->orderBy('firstname')->paginate(20);
        } else {
            if ($search)
                $users = User::latest()
                    ->where('firstname', 'like', '%' . $search . '%')
                    ->OrWhere('lastname', 'like', '%' . $search . '%')
                    ->OrWhere('identification', 'like', '%' . $search . '%')
                    ->orderBy('firstname')
                    ->paginate(20);
            else $users = User::orderBy('firstname')->paginate(20);
        }
        $programs = $this->user->programs;
        $roles = Role::all();
        if ($search)
            $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userssearch', 'value' => 'Búsqueda de usuarios: ' . $search]);
        else $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'users', 'value' => 'Ver listado de usuarios']);
        foreach ($users as $us) {
            if ($us->firstname != trim(ucwords(strtolower($us->firstname))))
                $us->update(['firstname' => trim(ucwords(strtolower($us->firstname)))]);
            if ($us->lastname != trim(ucwords(strtolower($us->lastname))))
                $us->update(['lastname' => trim(ucwords(strtolower($us->lastname)))]);
        }
        return view('users.index', compact('users', 'option', 'programs', 'roles', 'search'));

    }

    /**
     * Displays users filtered by the given Status
     * @param $status
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function byStatus(Request $request, $status)
    {
        $option = "status";
        $programs = $this->user->programs;
        $roles = Role::all();
        $search = $request->get('search', '');
        if ($search)
            $users = User::where('status', $status)->where(function ($query) use ($search) {
                $query->where('firstname', 'like', '%' . $search . '%')
                    ->OrWhere('lastname', 'like', '%' . $search . '%')
                    ->OrWhere('identification', 'like', '%' . $search . '%');
            })->orderBy('firstname')->paginate(20);
        else $users = User::where('status', $status)->orderBy('firstname')->paginate(20);

        return view('users.index', compact('users', 'option', 'programs', 'roles', 'search'));
    }

    /**
     * Lists user that are related to the given program
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function byProgram(Request $request, Program $program)
    {
        if ($this->user->cannot('listByProgram', [new User, $program])) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/');
        }
        $option = "program";
        $search = $request->get('search', '');
        $channel = $request->get('channel', '');
        $role = $request->get('role', '');
        $query = $program->users();
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('firstname', 'like', '%' . $search . '%')
                    ->OrWhere('lastname', 'like', '%' . $search . '%')
                    ->OrWhere('identification', 'like', '%' . $search . '%');
            });
        }
        if ($channel) {
            $query->whereHas('channels', function ($query) use ($channel) {
                $query->where('program_channels.id', $channel);
            });
        }
        if ($role) {
            $query->whereHas('roles', function ($query) use ($role) {
                $query->where('roles.id', $role);
            });
        }

        $users = $query->orderBy('firstname')->paginate(20);
        $programs = $this->user->programs;
        $roles = Role::all();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'usersbyprogram', 'value' => 'Ver listado de usuarios del programa: ' . $program->name]);
        return view('users.index', compact('users', 'option', 'programs', 'program', 'roles', 'search', 'channel', 'role'));

    }

    /**
     * Lists users that have been deleted
     * @param Request $request
     * @param string $option
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|string
     */
    public function trashed(Request $request, $option = 'list', $id = null)
    {
        if ($this->user->cannot('list', new User)) {
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
     * Completely remove user from trashed items
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function deltrashed(Request $request, $id)
    {
        $us = User::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $us)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/users');
            }
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userdeltrashed', 'value' => 'Usuario eliminado definitivamente:' . $us->name . ' (ID:' . $us->id . ')', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        $us->forceDelete();
        return "ok";
    }

    public function restoretrashed(Request $request, $id)
    {
        $us = User::withTrashed()->find($id);
        if ($this->user->cannot('destroy', $us)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/users');
            }
        }
        $us->restore();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userrestore', 'value' => 'Usuario restaurado: <a href="/users/' . $us->id . '"><em>' . $us->name . ' (ID:' . $us->id . ')</em></a>', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        return "ok";
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
        if ($this->user->cannot('create', new User)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }

        $validationmessages = [
            'firstname.required'    => 'El nombre propio del usuario es requerido!',
            'email.required'        => 'El correo electrónico del usuario es requerido!',
            'email.unique'          => 'Este correo ya existe en la base de datos!',
            'identification.unique' => 'Esta cédula ya existe en la base de datos!',
        ];
        $validator = Validator::make($request->all(), [
            'firstname'      => 'required',
            'email'          => 'email|unique:users',
            'identification' => 'unique:users',
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
        $user = User::create($request->all());
        $user->programs()->sync($request->get('programs', []));
        $user->roles()->sync($request->get('roles', []));
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'usercreate', 'value' => 'Usuario creado: <a href="/users/' . $user->id . '"><em>' . $user->name . ' (ID:' . $user->id . ')</em></a>', 'model_id' => $user->id, 'model_type' => get_class($user)]);
        Flash::success('Usuario creado!');
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if ($this->user->cannot('show', $user)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userview', 'value' => 'Visualización del perfil del usuario: ' . $user->name . '(ID: ' . $user->id . ')', 'model_id' => $user->id, 'model_type' => get_class($user)]);

        $profile = $user;
        $stats = $profile->stats()->paginate(20);
        return view('users.show', compact('profile', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        if ($this->user->cannot('edit', $user)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $us = $user;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'useredit', 'value' => 'Editando usuario: <a href="/users/' . $us->id . '"><em>' . $us->name . ' (ID:' . $us->id . ')</em></a>', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        if ($this->user->id == 1) {
            $programs = Program::all();
            $channels = Channel::all();
        } else {
            $programs = $this->user->programs;
            $channels = $this->user->channels;
        }
        $roles = Role::all();
        return view('users.edit', compact('us', 'programs', 'roles', 'channels'));

    }

    /**
     * Show challenges details for this user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function challenges(Request $request, User $user)
    {
        if ($this->user->cannot('show', $user)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $us = $user;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userchallenges', 'value' => 'Viendo desafíos del usuario: <a href="/users/' . $us->id . '"><em>' . $us->name . ' (ID:' . $us->id . ')</em></a>', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        $programs = $this->user->programs;
        $channels = $this->user->channels;
        $roles = Role::all();
        return view('users.challenges', compact('us', 'programs', 'roles', 'channels'));
    }

    /**
     * Show variables loaded for this user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function variables(Request $request, User $user)
    {
        if ($this->user->cannot('show', $user)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $us = $user;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'uservariables', 'value' => 'Viendo variables del usuario: <a href="/users/' . $us->id . '"><em>' . $us->name . ' (ID:' . $us->id . ')</em></a>', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        $programs = $this->user->programs;
        $channels = $this->user->channels;
        $roles = Role::all();
        return view('users.variables', compact('us', 'programs', 'roles', 'channels'));
    }

    /**
     * Show goals loaded for this user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function goals(Request $request, User $user)
    {
        if ($this->user->cannot('show', $user)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $us = $user;
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'usergoals', 'value' => 'Viendo metas del usuario: <a href="/users/' . $us->id . '"><em>' . $us->name . ' (ID:' . $us->id . ')</em></a>', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        $programs = $this->user->programs;
        $channels = $this->user->channels;
        $roles = Role::all();
        return view('users.goals', compact('us', 'programs', 'roles', 'channels'));
    }

    /**
     * Displays the import form
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function import(Request $request, Program $program)
    {
        if ($this->user->cannot('create', new User)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userimport', 'value' => 'Importando usuarios en: ' . $program->name]);
        return view('users.import', compact('program'));
    }

    /**
     * Process the imported excel file
     * @param Request $request
     * @param Program $program
     * @return array
     */
    public function processImport(Request $request, Program $program)
    {
        if ($request->ajax()) {
            if ($file = $request->file('file')) {
                $this->validate($request, [
                    'file' => 'required|mimes:xls,xlsx'
                ]);
                $results = Excel::load($file->getPathname(), function ($reader) { })->get();
                //                $exists = collect([]);
                //                $trashed = collect([]);
                //                $created = collect([]);
                //                $errors = collect([]);
                $messages = collect([]);
                $columns = [];
                $transforms = [];
                $variables = [];
                foreach ($results->first() as $row) {
                    if (!$columns) {
                        $columns = $row->keys()->toArray();
                        $messages->push('<span class="text-primary"><strong>Columnas del archivo: </strong></span> ');
                        foreach ($columns as $column) {
                            if (in_array($column, array_keys($this->user->getAttributes()))) {
                                $messages->push('<span class="text-success">' . $column . '</span> ');
                                $transforms[$column] = $column;
                            } elseif ($field = $program->fields()->where('slug', $column)->first()) {
                                $messages->push('<span class="text-success">(' . $column . ')</span> ');
                                $transforms[$column] = $field->field;
                            } elseif (in_array($column, ['canal', 'channel'])) {
                                $messages->push('<span class="text-info">' . $column . '</span> ');
                                $transforms[$column] = 'channel';
                            } elseif (in_array($column, ['canales', 'channels'])) {
                                $messages->push('<span class="text-info">' . $column . '</span> ');
                                $transforms[$column] = 'channels';
                            } elseif (in_array($column, ['rol', 'role', 'perfil', 'group', 'grupo'])) {
                                $messages->push('<span class="text-info">' . $column . '</span> ');
                                $transforms[$column] = 'role';
                            } elseif (in_array($column, ['roles', 'perfiles', 'groups', 'grupos'])) {
                                $messages->push('<span class="text-info">' . $column . '</span> ');
                                $transforms[$column] = 'roles';
                            } elseif (in_array($column, Variable::where('type', 'simple')->get()->pluck('slug')->toArray())) {
                                $messages->push('<span class="text-warning">' . $column . '</span> ');
                                $variables[] = $column;
                            } elseif (in_array($column, ['periodo', 'period', 'fecha', 'date', 'mes', 'month'])) {
                                $messages->push('<span class="text-primary">' . $column . '</span> ');
                                $transforms[$column] = 'period';
                            } else {
                                $messages->push('<span class="text-danger"> ' . $column . '</span> ');
                            }
                        }
                        $messages->push('<br>');
                        if (!in_array('identification', $transforms) && !in_array('identification', $columns)) {
                            $messages->push('<span class="text-danger"><strong>No se ha encontrado la columna con la identificación del usuario, y por tanto el archivo no procesado.</strong></span><br>');
                            break;
                        }
                    }
                    $data = [];
                    foreach ($transforms as $key => $value) {
                        if ($value == 'firstname' || $value == 'lastname')
                            $data[$value] = trim(ucwords(strtolower($row->$key)));
                        elseif ($value == 'identification')
                            $data[$value] = str_replace('.', '', $row->$key);
                        elseif ($value == 'email')
                            $data[$value] = str_replace(' ', '', $row->$key);
                        else
                            $data[$value] = $row->$key;
                        if ($data[$value] == '')
                            $data[$value] = null;
                        $row->$value = $data[$value];
                        unset($row->$key);
                    }
                    if ($row->identification) {
                        $record = User::firstOrCreate(['identification' => $row->identification]);
                        if (isset($data['parent_id'])) {
                            if ($parent = User::firstOrCreate(['identification' => $data['parent_id']])) {
                                $data['parent_id'] = $parent->id;
                            } else {
                                unset($data['parent_id']);
                            }
                        }
                        if (isset($data['channel'])) {
                            $ch = Channel::firstOrCreate(['name' => trim($data['channel']), 'program_id' => $program->id]);
                            $record->channels()->detach();
                            $record->channels()->attach($ch->id);
                            unset($data['channel']);
                        } elseif (isset($data['channels'])) {
                            $record->channels()->detach();
                            $chs = explode(',', $data['channels']);
                            foreach ($chs as $ch_name) {
                                $ch = Channel::firstOrCreate(['name' => trim($ch_name), 'program_id' => $program->id]);
                                $record->channels()->attach($ch->id);
                            }
                            unset($data['channels']);
                        }
                        if (isset($data['role'])) {
                            $rl = Role::firstOrCreate(['name' => trim($data['role'])]);
                            $record->roles()->detach();
                            $record->roles()->attach($rl->id);
                            unset($data['role']);
                        } elseif (isset($data['roles'])) {
                            $record->roles()->detach();
                            $rls = explode(',', $data['roles']);
                            foreach ($rls as $rl_name) {
                                $rl = Role::firstOrCreate(['name' => trim($rl_name)]);
                                $record->roles()->attach($rl->id);
                            }
                            unset($data['roles']);
                        }
                        if (isset($data['password'])) {
                            $data['password'] = bcrypt($data['password']);
                        }
                        if (isset($data['email'])) {
                            if (!str_contains($data['email'], '@')) {
                                if (trim($data['email']) != '')
                                    $messages->push('<span class="text-danger">Correo inválido:</span> ' . $data['email'] . '<br>');
                                unset($data['email']);
                            }
                        }
                        $record->update($data);
                        if (count($variables) > 0) {
                            if (!$row->period)
                                $messages->push('<span class="text-danger"><strong>Para cargar variables se debe incluir una columna con el periodo.</strong></span><br>');
                            else {
                                foreach ($variables as $variable) {
                                    if ($var = Variable::where('slug', $variable)->first()) {
                                        $value = Value::firstOrCreate(['user_id' => $record->id, 'variable_id' => $var->id, 'period' => date('Y-m-d H:i:s', strtotime($row->period))]);
                                        $value->update(['value' => $row->$variable]);
                                    }
                                }
                            }
                        }
                        $record->programs()->detach($program->id);
                        $record->programs()->attach($program->id);
                    }
                }
                $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userimport', 'value' => 'Importando ' . $results->count() . ' usuarios']);
                return compact('messages');
                //                return compact('exists', 'trashed', 'created', 'errors');

            }
        }
    }

    /**
     * Displays the liquidate form
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function liquidate(Request $request, Program $program)
    {
        if ($this->user->cannot('create', new User)) {
            Flash::error('No estás autorizado(a) para esto!');
            return redirect('/users');
        }
        $dates = collect(DB::table('user_values')->select('period')->distinct()->orderBy('period', 'desc')->get())->pluck('period')->toArray();
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userliquidate', 'value' => 'Liquidando usuarios en: ' . $program->name]);
        return view('users.liquidate', compact('program', 'dates'));
    }

    public function processVariables(Program $program, $period)
    {
        $messages = collect([]);
        $total = 0;
        foreach ($program->variables as $variable) {
            if ($variable->type == 'percentage') {
                $values2 = Value::where('period', $period)->where('variable_id', $variable->variable2_id)->get();
                foreach ($values2 as $value2) {
                    $value1 = Value::where('period', $period)
                        ->where('variable_id', $variable->variable1_id)
                        ->where('user_id', $value2->user_id)
                        ->first();
                    if(!$value1 && str_contains(strtolower($variable->name),'cuota')){
                        $prevperiod = date('Y-m-01',strtotime($period)-(60*60*24*15));
                        $prevvalue1 = Value::where('period', $prevperiod)
                            ->where('variable_id', $variable->variable1_id)
                            ->where('user_id', $value2->user_id)
                            ->first();
                        if($prevvalue1){
                            $value1 = Value::firstOrCreate(['period'=>$period,
                                'variable_id'=>$variable->variable1_id,
                                'user_id'=>$value2->user_id,
                                'value'=>$prevvalue1->value
                            ]);
                        }
                    }
                    if ($value1->value > 0 && $value2) {
                        $new = Value::firstOrCreate([
                            'variable_id' => $variable->id,
                            'user_id'     => $value1->user_id,
                            'period'      => $period,
                        ]);
                        $percentage = round(100 * ($value2->value / $value1->value), 2);
                        if ($percentage != $new->value) {
                            $new->update(['value' => $percentage]);
                            $total++;
                        }
                    }
                }
            } else if ($variable->type == 'multiply') {
                $values1 = Value::where('period', $period)->where('variable_id', $variable->variable1_id)->get();
                foreach ($values1 as $value1) {
                    $value2 = Value::where('period', $period)
                        ->where('variable_id', $variable->variable2_id)
                        ->where('user_id', $value1->user_id)
                        ->first();
                    if ($value1->value > 0 && $value2) {
                        $new = Value::firstOrCreate([
                            'variable_id' => $variable->id,
                            'user_id'     => $value1->user_id,
                            'period'      => $period,
                        ]);
                        $muliply = $value2->value * $value1->value;
                        if ($muliply != $new->value) {
                            $new->update(['value' => $muliply]);
                            $total++;
                        }
                    }
                }
            }
        }
        $messages->push('Variables calculadas actualizadas: <span class="text-warning">' . $total . '</span><br>');
        return compact('messages');
    }

    public function processLiquidate(Challenge $challenge, $period)
    {
        $messages = collect([]);
        $total = 0;
        if ($challenge->channels->count()) {
            $ids = $challenge->channels->pluck('id')->toArray();
            $query = $challenge->program->users();
            $query->whereHas('channels', function ($query) use ($ids) {
                $query->whereIn('program_channels.id', $ids);
            });
            $users = $query->get();
            $messages->push('Canales: <span class="text-info">' . implode(', ', $challenge->channels->pluck('name')->toArray()) . '</span> Usuarios: <span class="text-info">' . $users->count() . '</span>');
            $goals = $challenge->goals()->whereIn('type', ['compare', 'multiply'])->get();
            $goals = $goals->merge($challenge->goals()->whereNotIn('type', ['compare', 'multiply']));
            foreach ($goals as $goal) {
                //                $messages->push('Meta: '.$goal->name.'<br>');
                foreach ($users as $us) {
                    $new = Goalvalue::firstOrCreate([
                        'user_id' => $us->id,
                        'goal_id' => $goal->id,
                        'period'  => $period
                    ]);
                    if ($goal->type = 'compare' && $goal->variable1 && $goal->variable2 && $goal->points_variable) {
                        if ($goal->variable1->type == 'constant') {
                            $val1 = $goal->variable1->constant_value;
                        } else {
                            if ($val1Obj = Value::where('user_id', $us->id)
                                ->where('period', $period)
                                ->where('variable_id', $goal->variable1_id)
                                ->first()
                            ) {
                                $val1 = $val1Obj->value;
                            } else {
                                $val1 = 0;
                            }
                        }
                        if ($goal->variable2->type == 'constant') {
                            $val2 = $goal->variable2->constant_value;
                        } else {
                            if ($val2Obj = Value::where('user_id', $us->id)
                                ->where('period', $period)
                                ->where('variable_id', $goal->variable2_id)
                                ->first()
                            ) {
                                $val2 = $val2Obj->value;
                            } else {
                                $val2 = 0;
                            }
                        }
                        if ($goal->pointsVariable->type == 'constant') {
                            $pointsval = $goal->pointsVariable->constant_value;
                        } else {
                            if ($pointsValObj = Value::where('user_id', $us->id)
                                ->where('period', $period)
                                ->where('variable_id', $goal->points_variable)
                                ->first()
                            ) {
                                $pointsval = $pointsValObj->value;
                            } else {
                                $pointsval = 0;
                            }
                        }
                        if ($goal->operator == '>=')
                            $val = ($val1 >= $val2);
                        if ($goal->operator == '<=')
                            $val = ($val1 <= $val2);
                        if ($goal->operator == '>')
                            $val = ($val1 > $val2);
                        if ($goal->operator == '<')
                            $val = ($val1 < $val2);
                        if ($goal->operator == '=')
                            $val = ($val1 == $val2);
                        $pointsval = ($val ? $pointsval : 0);
                        if($new->value != $val || $new->points != $pointsval)
                            $new->update(['value' => $val, 'points' => ($val ? $pointsval : 0)]);
                        $total += $new->points;
                    } else if ($goal->type = 'multiply' && $goal->variable1 && $goal->variable2 && $goal->points_variable) {
                        if ($goal->variable1->type == 'constant') {
                            $val1 = $goal->variable1->constant_value;
                        } else {
                            if ($val1Obj = Value::where('user_id', $us->id)
                                ->where('period', $period)
                                ->where('variable_id', $goal->variable1_id)
                                ->first()
                            ) {
                                $val1 = $val1Obj->value;
                            } else {
                                $val1 = 0;
                            }
                        }
                        if ($goal->variable2->type == 'constant') {
                            $val2 = $goal->variable2->constant_value;
                        } else {
                            $val2Obj = $us->getVariableValue($goal->variable2_id, $period);
                            if ($val2Obj = Value::where('user_id', $us->id)
                                ->where('period', $period)
                                ->where('variable_id', $goal->variable2_id)
                                ->first()
                            ) {
                                $val2 = $val2Obj->value;
                            } else {
                                $val2 = 0;
                            }
                        }
                        $val = $val1 * $val2;
                        if($new->value != ($val > 0) || $new->points != $val)
                            $new->update(['value' => ($val > 0), 'points' => $val]);
                        $total += $new->points;
                    } else if ($goal->type = 'composed') {
                        $goalsmet = 0;
                        foreach ($goal->goals as $gl) {
                            if (($goalval = $us->getGoalValue($gl->id, $period)) && $goalval->value) {
                                $goalsmet++;
                            }
                        }
                        if ($goal->points_variable) {
                            if ($goal->pointsVariable->type == 'constant') {
                                $pointsval = $goal->pointsVariable->constant_value;
                            } else {
                                if ($pointsValObj = Value::where('user_id', $us->id)
                                    ->where('period', $period)
                                    ->where('variable_id', $goal->points_variable)
                                    ->first()
                                ) {
                                    $pointsval = $pointsValObj->value;
                                } else {
                                    $pointsval = 0;
                                }
                            }
                        } else if ($goal->totalpercentage) {
                            $pointsval = 0;
                        }
                        if ($goalsmet > $goal->composednumber) {
                            if(!$new->value || $new->points != $pointsval)
                                $new->update(['value' => true, 'points' => $pointsval]);
                        }
                    } else if ($goal->type = 'grouptotal2') {
                        $total = $us->users->count();
                        $totalok = 0;
                        $totalpoints = 0;
                        foreach ($us->users as $subuser) {
                            $userpoints = 0;
                            foreach ($goal->goals as $gl) {
                                if (!($goalval = $subuser->getGoalValue($gl->id, $period)) || !$goalval->value) {
                                    break;
                                }
                                $userpoints += $goalval->points;
                            }
                            $totalok++;
                            $totalpoints += $userpoints;
                        }
                        if(round(100*$totalok/$total) >= $goal->percentage){
                            $pointsval = round($totalpoints*($goal->totalpercentage/100));
                            if(!$new->value || $new->points != $pointsval)
                                $new->update(['value' => true, 'points' => $pointsval]);
                        }
                    }
                }
            }
        } else {
            $messages->push('Desafío: <span class="text-info">' . $challenge->name . '</span>: <span class="text-danger">No hay canales asociados.</span>');
        }
        $messages->push(' Puntos: <span class="text-info">' . $total . '</span>');
        sleep(2);
        $id = $challenge->id;
        return compact('messages', 'id');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($this->user->cannot('edit', $user)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/users');
            }
        }
        $us = $user;
        if ($request->ajax()) {
            if ($file = $request->file('file')) {
                $this->validate($request, [
                    'file' => 'required|mimes:jpg,jpeg,png'
                ]);
                $name = $file->getClientOriginalName();
                $path = 'images/users/' . $us->id . '/' . cleanUrl($name);
                $file->move($path);
                $us->update(['avatar' => '/' . $path]);
                $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userimageupdate', 'value' => 'Imagen de usuario actualizada: <a href="/users/' . $user->id . '"><em>' . $user->name . ' (ID:' . $user->id . ')</em></a>', 'model_id' => $user->id, 'model_type' => get_class($user)]);
                return $path;
            }
        }
        $data = $request->all();
        if (isset($data['parent_id']))
            $data['parent_id'] = str_replace(')', '', substr($data['parent_id'], strpos($data['parent_id'], '(ID:') + 4));
        if ($data['parent_id'] == '')
            unset($data['parent_id']);
        if ($data['identification'] == '')
            unset($data['identification']);
        if ($data['birth'] == '')
            unset($data['birth']);
        if ($data['email'] == '')
            $data['email'] = null;
        //        dd($data);
        $this->validate($request, [
            'identification' => 'unique:users,identification,' . $us->id,
            'email'          => 'unique:users,email,' . $us->id
        ]);
        $us->update($data);
        $us->programs()->sync($request->get('programs', []));
        $us->channels()->sync($request->get('channels', []));
        $us->roles()->sync($request->get('roles', []));
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userupdate', 'value' => 'Usuario actualizado: <a href="/users/' . $us->id . '"><em>' . $us->name . ' (ID:' . $us->id . ')</em></a>', 'model_id' => $us->id, 'model_type' => get_class($us)]);
        Flash::success('Usuario actualizado!');
        return redirect('/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($this->user->cannot('destroy', $user)) {
            if ($request->ajax()) {
                return 'No estás autorizado(a) para esto!';
            } else {
                Flash::error('No estás autorizado(a) para esto!');
                return redirect('/users');
            }
        }
        if ($user->id == $this->user->id) {
            if ($request->ajax()) {
                return 'No se puede eliminar su propio usuario';
            } else {
                Flash::error('No se puede eliminar su propio usuario!');
                return redirect('/users');
            }
        }
        $this->user->stats()->create(['ip' => $request->ip(), 'action' => 'userdestroy', 'value' => 'Usuario eliminado: ' . $user->name . ' (ID:' . $user->id . ')', 'model_id' => $user->id, 'model_type' => get_class($user)]);
        $user->delete();
        if ($request->ajax()) {
            return 'ok';
        } else {
            Flash::success('Usuario eliminado!');
            return redirect('/users');
        }
    }
}
