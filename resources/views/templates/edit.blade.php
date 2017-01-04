<div>
    <form action="/import_templates/{{ $template->id }}" method="post" autocomplete="off">
        {!! csrf_field() !!}
        {{ method_field('PUT') }}
        <header class="slidePanel-header">
            <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
                <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                    <button type="button" class="btn btn-pure slidePanel-close md-close" aria-hidden="true"></button>
                </div>
                <h4 class="stage-name">Editar plantilla: @{{ name }}</h4>
            </div>
        </header>
        <div class="slidePanel-inner">
            <section class="slidePanel-inner-section">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <button type="submit" class="btn btn-success"><i class="icon md-floppy"></i> Guardar</button>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$template->name) }}"/>
                            <div class="hint">Escriba el nombre de la plantilla</div>
                            <label class="floating-label" for="name">Nombre </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group form-material">
                            <label class="" for="roles[]">Roles</label>
                            @foreach($roles as $role)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($template->roles()->where('roles.id',$role->id)->first())?'checked':'' }}
                                           type="checkbox" class="" id="role_{{ $role->id }}" name="roles[]" data-roleid="{{ $role->id }}"
                                           value="{{ $role->id }}"/>
                                    <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <div class="form-group form-material">
                            <label class="" for="channels[]">Canales</label>
                            @foreach($channels as $channel)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($template->channels()->where('program_channels.id',$channel->id)->first())?'checked':'' }}
                                           type="checkbox" class="" id="channel_{{ $channel->id }}" name="channels[]"
                                           data-channelid="{{ $channel->id }}"
                                           value="{{ $channel->id }}"/>
                                    <label for="channel_{{ $channel->id }}">{{ $channel->name }}</label>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group form-material">
                            <label class="" for="variables[]">Variables simples</label>
                            <div class="input-search input-search-dark">
                                <i class="input-search-icon md-search" aria-hidden="true"></i>
                                <input type="text" class="form-control" name="filter" v-model="filter" placeholder="Filtrar..." value="" >
                            </div>
                        @foreach($challenges as $challenge)
                                @foreach($challenge['variables'] as $variable)
                                    <span class="checkbox-custom checkbox-primary checkbox-lg variable" v-show="filter=='' || ('{{ $variable->name }}'.toLowerCase().indexOf(filter) > -1)">
                                        <input {{ ($template->variables()->where('program_variables.id',$variable->id)->first())?'checked':'' }}
                                               type="checkbox" class="" id="variable_{{ $variable->id }}" name="variables[]"
                                               data-variableid="{{ $variable->id }}"
                                               value="{{ $variable->id }}"/>
                                        <label for="variable_{{ $variable->id }}">{{ $variable->name }}<br>
                                            <span class="small text-info">{{ $challenge['challenge']->name }}, {{ $variable->goals()->count() }} Meta(s) </span></label>
                                    </span>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        new Vue({
            el: '#app',
            data: {name: '',
                filter:''
            }
        });
    });

</script>
