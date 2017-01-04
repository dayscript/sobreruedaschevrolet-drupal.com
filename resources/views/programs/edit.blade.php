<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-green-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar programa: @{{ name }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="nav-tabs-animate">
                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                    <li class="active" role="presentation"><a data-toggle="tab" href="#general" aria-controls="general" role="tab">Datos Generales</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#channels" aria-controls="channels" role="tab">Canales</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#fields" aria-controls="fields" role="tab">Configurar Campos</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active animation-slide-left" id="general" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                @if($media = $program->getMedia()->first())
                                    <img id="projectImage" class="img-responsive" src="{{ $media->getUrl() }}">
                                @endif
                                <form id="myId" action="/programs/{{ $program->id}}" class="dropzone" method="post">
                                    {!! csrf_field() !!}
                                    {{ method_field('PUT') }}
                                </form>
                            </div>
                            <div class="col-md-8">
                                <form action="/programs/{{ $program->id }}" method="post" autocomplete="off">
                                    {!! csrf_field() !!}
                                    {{ method_field('PUT') }}
                                    <div class="form-group form-material floating">
                                        <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$program->name) }}"/>
                                        <div class="hint">Escriba un nombre para este programa</div>
                                        <label class="floating-label" for="name">Nombre del programa</label>
                                    </div>
                                    <div class="form-group form-material floating">
                                        <input type="text" class="form-control" name="client" value="{{ old('client',$program->client) }}"/>
                                        <div class="hint">Nombre del cliente de este programa</div>
                                        <label class="floating-label" for="client">Empresa cliente</label>
                                    </div>
                                    <div class="form-group form-material floating">
                            <textarea
                                    class="form-control {{ old('description',$program->description)?old('description',$program->description):'empty' }}"
                                    rows="3" name="description">{{ old('description',$program->description) }}</textarea>
                                        <div class="hint">Describa en pocas palabras el objetivo de este programa.</div>
                                        <label class="floating-label" for="description">Descripción</label>
                                    </div>
                                    <div class="form-group form-material ">
                                        <label class="" for="datepicker"><strong>
                                                <small>Inicio y finalización del programa</small>
                                            </strong></label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon">Inicio</span>
                                            <input type="text" class="input-sm form-control" name="start"
                                                   value="{{ old('start',$program->start?$program->start->toDateString():'') }}"/>
                                            <span class="input-group-addon">Fin</span>
                                            <input type="text" class="input-sm form-control" name="end"
                                                   value="{{ old('end',$program->end?$program->end->toDateString():'') }}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-material floating">
                                                <input type="text" class="form-control" name="pointsname"
                                                       value="{{ old('pointsname',$program->pointsname) }}"/>
                                                <div class="hint">El nombre que se usará para referirse a los puntos en este programa</div>
                                                <label class="floating-label" for="pointsname">Nombre del punto</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-material floating">
                                                <input type="number" class="form-control" name="pointsvalue"
                                                       value="{{ old('pointsvalue',$program->pointsvalue) }}"/>
                                                <div class="hint">El valor equivalente de cada punto en este programa</div>
                                                <label class="floating-label" for="pointsvalue">Valor del punto</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-material floating">
                                                <input type="text" class="form-control" name="pointslimit"
                                                       value="{{ old('pointslimit',$program->pointslimit) }}"/>
                                                <div class="hint">El día del mes en el que deben estar cargados los puntos</div>
                                                <label class="floating-label" for="pointslimit">Día límite de carga de puntos</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-material floating">
                                                <input type="number" class="form-control" name="userslimit"
                                                       value="{{ old('userslimit',$program->userslimit) }}"/>
                                                <div class="hint">El día del mes en el que deben estar cargados los cambios de usuarios</div>
                                                <label class="floating-label" for="userslimit">Día limite de carga de usuarios</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-material floating">
                            <textarea
                                    class="form-control {{ old('terms',$program->terms)?old('terms',$program->terms):'empty' }}"
                                    rows="5" name="terms">{{ old('terms',$program->terms) }}</textarea>
                                        <div class="hint">Términos puntuales que deben aceptar los usuarios del programa.</div>
                                        <label class="floating-label" for="terms">Términos y condiciones</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Guardar" class="btn btn-primary">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active animation-slide-left" id="fields" role="tabpanel">
                        <div class="clear"><br></div>
                        <form action="/programs/{{ $program->id }}" method="post" autocomplete="off">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <p>Estos son los campos disponibles para los usuarios en este programa. Puede agregar palabras claves a cada campo, que pueden ser
                                usadas al cargar la información de usuarios al sistema para facilitar el proceso.</p>
                            @foreach(\App\Manager\Programs\Program::getFields() as $key=>$value)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group tokenfield">
                                                <span class="input-group-addon">{{ $value }}<br><small>{{ $key }}</small></span>
                                                <input type="text" name="fields[{{ $key }}]" class="form-control"
                                                       value="{{ implode(',',$program->fields()->where('field',$key)->get()->pluck('value')->toArray()) }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <input type="submit" value="Actualizar" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane active animation-slide-left" id="channels" role="tabpanel">
                        <div class="clear"><br></div>
                        <form action="/programs/{{ $program->id }}" method="post" autocomplete="off">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <p>Estos son los canales asociados a este programa.</p>
                            @forelse($program->channels as $channel)
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group form-material floating">
                                            <input type="text" class="form-control" name="channel_{{ $channel->id }}" value="{{ $channel->name }}"/>
                                            <div class="hint">Nombre del canal</div>
                                            <label class="floating-label" for="name">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <br>
                                            <input name="channelupdate[{{ $channel->id }}]" type="submit" value="Actualizar" class="btn btn-sm btn-primary">
                                            <input name="channeldelete[{{ $channel->id }}]" type="submit" value="Eliminar" class="btn btn-sm btn-primary">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="well">
                                    No hay canales creados para este programa
                                </div>
                            @endforelse
                                <div class="panel">
                                    <div class="panel-heading">Agregar nuevo canal</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group form-material floating">
                                                    <input type="text" class="form-control" name="newchannel" value=""/>
                                                    <div class="hint">Nombre del nuevo canal</div>
                                                    <label class="floating-label" for="name">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <br>
                                                    <input type="submit" value="Agregar" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
<script>
    $(document).ready(function () {
        new Vue({el: '#app', data: {name: ''}});
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            language: "es"
        });
        $('.tokenfield input')
                .on('tokenfield:createtoken', function (e) {
                    console.log(e.attrs);
                    return {value: 'ok', label: 'ok'};
                })
                .tokenfield({});
        Dropzone.options.myId = {
            paramName: 'file',
            maxFileSize: 4,
            uploadMultiple: false,
            acceptedFiles: '.jpg, .jpeg, .png',
            dictDefaultMessage: 'Arrastre o haga click aquí para cargar una imagen',
            dictFallbackMessage: 'Su navegador no soporta la funcionalidad de arrastrar y soltar',
            init: function () {
                this.on("queuecomplete", function (file) {
                    location.reload();
                });
            }
        };
        var myDropzone = new Dropzone("#myId");
        myDropzone.on("success", function (file, data) {
            $('#projectImage').attr("src", data);
            myDropzone.removeFile(file);
        });
    });

</script>
