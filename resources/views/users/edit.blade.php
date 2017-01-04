<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar usuario: @{{ firstname }} @{{ lastname }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group form-material empty">
                        <label class="label margin-bottom-15 normal" for="status">Estado</label>
                        <select name="status" id="status" class="form-control" v-model="status">
                            @foreach(\App\User::statuses() as $key=>$value)
                                <option {{ $us->status == $key?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="hint">Defina un estado para este usuario</div>
                    </div>
                    <img id="userImage" class="img-responsive" src="{{ $us->avatar }}">
                    <form id="myId" action="/users/{{ $us->id}}" class="dropzone" method="post">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                    </form>
                </div>
                <div class="col-md-8">
                    <form action="/users/{{ $us->id }}" method="post" autocomplete="off">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="status" v-model="status" value="{{ old('status',$us->status) }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="number" class="form-control" name="identification" value="{{ old('identification',$us->identification) }}"/>
                                    <div class="hint">Escriba la identificación (cédula) del usuario</div>
                                    <label class="floating-label" for="identification">Identificación</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group form-material floating ">
                                    <input type="text" class="form-control input-datepicker" name="birth" value="{{ old('birth',$us->birth?$us->birth->toDateString():'') }}"/>
                                    <div class="hint">Fecha de nacimiento</div>
                                    <label class="floating-label" for="country">Fecha de nacimiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" v-model="firstname" name="firstname"
                                           value="{{ old('firstname',$us->firstname) }}"/>
                                    <div class="hint">Escriba el nombre propio del usuario</div>
                                    <label class="floating-label" for="firstname">Nombre propio</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" v-model="lastname" name="lastname"
                                           value="{{ old('lastname',$us->lastname) }}"/>
                                    <div class="hint">Escriba los apellidos del usuario</div>
                                    <label class="floating-label" for="lastname">Apellidos</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="email" class="form-control" name="email" value="{{ old('email',$us->email) }}"/>
                            <div class="hint">Escriba el correo electrónico</div>
                            <label class="floating-label" for="email">E-Mail</label>
                        </div>
                        <div class="form-group form-material">
                            <label class="" for="programs[]">Programas</label>
                            @foreach($programs as $program)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($us->programs()->where('programs.id',$program->id)->first())?'checked':'' }} type="checkbox" class=""
                                           id="program_{{ $program->id }}" name="programs[]" data-programid="{{ $program->id }}"
                                           value="{{ $program->id }}"/>
                                    <label for="program_{{ $program->id }}">{{ $program->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <hr>
                        <div class="form-group form-material">
                            <label class="" for="channels[]">Canales</label>
                            @foreach($channels as $channel)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($us->channels()->where('program_channels.id',$channel->id)->first())?'checked':'' }} type="checkbox" class=""
                                           id="channel_{{ $channel->id }}" name="channels[]" data-channelid="{{ $channel->id }}"
                                           value="{{ $channel->id }}"/>
                                    <label for="channel_{{ $channel->id }}">{{ $channel->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <hr>
                        <div class="form-group form-material">
                            <label class="" for="roles[]">Roles</label>
                            @foreach($roles as $role)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($us->roles()->where('roles.id',$role->id)->first())?'checked':'' }} type="checkbox" class=""
                                           id="role_{{ $role->id }}" name="roles[]" data-roleid="{{ $role->id }}" value="{{ $role->id }}"/>
                                    <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <hr>
                        <div class="row form-group form-material">
                            <label class="" for="parent_id">Jefe / Responsable</label>
                            <input class="form-control typeahead" type="text" id="parent_id" name='parent_id'
                                   placeholder="Escoja un usuario superior en la jerarquía"
                                   value="{{ $us->parent_id?$us->parent->name . ' (ID:'.$us->parent_id.')':'' }}">
                        </div>
                        <div class="row form-group form-material floating ">
                            <input type="text" class="form-control" name="address" value="{{ old('address',$us->address) }}"/>
                            <div class="hint">Dirección de correspondencia</div>
                            <label class="floating-label" for="address">Dirección</label>
                        </div>
                        <div class="row form-group form-material floating ">
                            <input type="text" class="form-control" name="address2" value="{{ old('address2',$us->address2) }}"/>
                            <div class="hint">Información adicional de dirección</div>
                            <label class="floating-label" for="address2">Complemento de dirección</label>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row form-group form-material floating ">
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile',$us->mobile) }}"/>
                                    <div class="hint">No. de teléfono móvil</div>
                                    <label class="floating-label" for="mobile">Celular</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row form-group form-material floating ">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone',$us->phone) }}"/>
                                    <div class="hint">No. de teléfono fijo</div>
                                    <label class="floating-label" for="phone">Teléfono fijo</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row form-group form-material floating ">
                                    <input type="text" class="form-control" name="fax" value="{{ old('fax',$us->fax) }}"/>
                                    <div class="hint">No. de Fax</div>
                                    <label class="floating-label" for="fax">Fax</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row form-group form-material floating ">
                                    <input type="text" class="form-control" name="city" value="{{ old('city',$us->city) }}"/>
                                    <div class="hint">Ciudad de residencia</div>
                                    <label class="floating-label" for="city">Ciudad</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group form-material floating ">
                                    <input type="text" class="form-control" name="country" value="{{ old('country',$us->country) }}"/>
                                    <div class="hint">País de residencia</div>
                                    <label class="floating-label" for="country">País</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Guardar" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.input-datepicker').datepicker({
            format: "yyyy-mm-dd",
            language: "es"
        });
        new Vue({
            el: '#app',
            data: {firstname: '',lastname:'',status:'{{ $us->status }}'}
        });
        var userSearch = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/search/users/%QUERY',
                wildcard: '%QUERY'
            }
        });

        $('#parent_id').typeahead(null, {
            name: 'user-search',
            display: 'name',
            source: userSearch
        });
        Dropzone.options.myId = {
            paramName: 'file',
            maxFileSize: 4,
            uploadMultiple: false,
            acceptedFiles: '.jpg, .jpeg, .png',
            dictDefaultMessage: 'Arrastre o haga click aquí para cargar una imagen',
            dictFallbackMessage: 'Su navegador no soporta la funcionalidad de arrastrar y soltar',
            init: function () {
                this.on("queuecomplete", function (file) {
//                    location.reload();
                });
            }
        };
        var myDropzone = new Dropzone("#myId");
        myDropzone.on("success", function (file, data) {
            $('#userImage').attr("src", data);
            myDropzone.removeFile(file);
        });
    });

</script>
