<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Manager\Programs\Channel;
use App\Manager\Programs\Field;
use App\Manager\Programs\Program;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;


class ProgramsController extends Controller
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
        $programs = Program::latest()->paginate(20);
        $this->user->stats()->create(['ip'=>$request->ip(),'action'=>'programs','value'=>'Ver listado de programas']);
        return view('programs.index',compact('programs'));
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
        $program = Program::create($request->all());
        $this->user->stats()->create(['ip'=>$request->ip(),'action'=>'programcreate','value'=>'Programa creado: <a href="/programs/'. $program->id .'"><em>'.$program->name . ' (ID:'. $program->id.')</em></a>', 'model_id'=>$program->id,'model_type'=>get_class($program)]);
        Flash::success('Programa creado!');
        return redirect('/programs');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Program $program)
    {
        $this->user->stats()->create(['ip'=>$request->ip(),'action'=>'programview','value'=>'Programa visto: <a href="/programs/'. $program->id .'"><em>'.$program->name . ' (ID:'. $program->id.')</em></a>', 'model_id'=>$program->id,'model_type'=>get_class($program)]);
        return view('programs.show',compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Program $program)
    {
        $this->user->stats()->create(['ip'=>$request->ip(),'action'=>'programedit','value'=>'Editando programa: <a href="/programs/'. $program->id .'"><em>'.$program->name . ' (ID:'. $program->id.')</em></a>',  'model_id'=>$program->id,'model_type'=>get_class($program)]);
        return view('programs.edit',compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Program $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        if($request->ajax()){
            if($file = $request->file('file')){
                $this->validate($request, [
                    'file' => 'required|mimes:jpg,jpeg,png'
                ]);
                $name = $file->getClientOriginalName();
                $file->move('images/programs/' . $program->id . '/', cleanUrl($name));
                $program->clearMediaCollection();
                $media = $program->addMedia('images/programs/' . $program->id . '/' . cleanUrl($name))
                    ->usingFileName(cleanUrl($name))
                    ->usingName('image')
                    ->toMediaLibrary();
                return $media->getUrl();
            }
        } else if($channelupdate = $request->get('channelupdate',[])){
            foreach ($channelupdate as $key=>$val){
                $channel = Channel::find($key);
                $channel->update(['name'=>$request->get('channel_'. $key ,$channel->name)]);
            }
            Flash::success('Canal actualizado!');
            return redirect('/programs');
        } else if($channeldelete = $request->get('channeldelete',[])){
            foreach ($channeldelete as $key=>$val){
                $channel = Channel::find($key);
                $channel->delete();
            }
            Flash::success('Canal eliminado!');
            return redirect('/programs');
        } else if($newchannel = $request->get('newchannel','')){
            $program->channels()->create(['name'=>$newchannel]);
            Flash::success('Canal agregado!');
            return redirect('/programs');
        } else if($fields = $request->get('fields',[])){
            $program->fields()->delete();
            foreach ($fields as $key=>$value){
                $items = explode(',', $value);
                foreach ($items as $item){
                    if(trim($item)){
                        $fi = Field::firstOrCreate(['field'=>$key,'program_id'=>$program->id,'value'=>trim($item)]);
                        $fi->update(['slug'=>str_slug(trim($item),'_')]);
                    }
                }
            }
            Flash::success('Campos de programa actualizados!');
            return redirect('/programs');
        }
        $data = $request->all();
        if($data['start']=='')unset($data['start']);
        if($data['end']=='')unset($data['end']);
        $program->update($data);
        $this->user->stats()->create(['ip'=>$request->ip(),'action'=>'programupdate','value'=>'Programa actualizado: <a href="/programs/'. $program->id .'"><em>'.$program->name . ' (ID:'. $program->id.')</em></a>',  'model_id'=>$program->id,'model_type'=>get_class($program)]);
        Flash::success('Programa actualizado!');
        return redirect('/programs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy( Request $request, Program $program)
    {
        $program->delete();
        $this->user->stats()->create(['ip'=>$request->ip(),'action'=>'programdestroy','value'=>'Programa eliminado: <a href="/programs/'. $program->id .'"><em>'.$program->name . ' (ID:'. $program->id.')</em></a>', 'model_id'=>$program->id,'model_type'=>get_class($program)]);
        if($request->ajax()){
            return 'ok';
        } else {
            Flash::success('Programa eliminado!');
            return redirect('/programs');
        }
    }

    /**
     * Adds an agreement to user table for this program
     * @param Program $program
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function agreeTerms(Program $program)
    {
        $this->user->agreements()->attach($program->id);
        $user = $this->user;
        Mail::queue('emails.agreeterms', ['user' => $user, 'program'=>$program], function ($m) use ($user, $program) {
            $m->to($user->email, $user->name)->subject('Aceptaste los TyC: '.$program->name);
        });
        Flash::success('Aceptaste los términos y condiciones!');
        return redirect('/');
    }
}
