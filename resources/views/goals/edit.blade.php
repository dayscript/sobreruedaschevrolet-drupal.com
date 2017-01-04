<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar meta: @{{ name }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="row">
                <div class="col-md-12">
                    <form action="/goals/{{ $goal->id }}" method="post" autocomplete="off">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$goal->name) }}"/>
                                    <div class="hint">Escriba el nombre de la meta</div>
                                    <label class="floating-label" for="name">Nombre </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material empty ">
                                    <label class="label margin-bottom-15 normal" for="model">Desafío</label>
                                    <select name="challenge" id="challenge" class="form-control">
                                        @foreach($challenges as $ch)
                                            <option {{ $goal->challenge_id == $ch->id?'selected':'' }} value="{{ $ch->id }}">{{ $ch->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="hint">Escoja el desafío</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-material empty ">
                                    <label class="label margin-bottom-15 normal" for="model">Rol</label>
                                    <select name="rol" id="rol" class="form-control">
                                        @foreach($roles as $rl)
                                            <option {{ $goal->role_id == $rl->id?'selected':'' }} value="{{ $rl->id }}">{{ $rl->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="hint">Escoja el rol al que aplica esta meta</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-material empty ">
                                    <label class="label margin-bottom-15 normal" for="group">Grupal o Individual</label>
                                    <select name="group" id="group" class="form-control" v-model="group">
                                        <option {{ $goal->group == 0?'selected':'' }} value="0">Individual</option>
                                        <option {{ $goal->group == 1?'selected':'' }} value="1">Grupal</option>
                                    </select>
                                    <div class="hint">Defina si es una meta aplicable al usuario a su grupo de subalternos</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-material floating" v-show="group=='1'">
                                    <input type="text" class="form-control" name="percentage" value="{{ old('percentage',$goal->percentage) }}"/>
                                    <div class="hint">Porcentaje del grupo que deben cumplir la meta</div>
                                    <label class="floating-label" for="name">Porcentaje del grupo </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material empty ">
                                    <label class="label margin-bottom-15 normal" for="model">Tipo de meta</label>
                                    <select name="type" id="type" class="form-control" v-model="type">
                                        @foreach(\App\Manager\Challenges\Goal::getTypes() as $key=>$value)
                                            <option {{ $goal->type == $key?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="hint">Escoja el Tipo</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{--<div class="form-group form-material floating" v-show="type=='compare'">--}}
                                    {{--<input type="text" class="form-control" name="points" value="{{ old('points',$goal->points) }}"/>--}}
                                    {{--<div class="hint">Puntos a asignar al cumplirse esta meta</div>--}}
                                    {{--<label class="floating-label" for="name">Puntos </label>--}}
                                {{--</div>--}}
                                <div class="row form-group form-material" v-show="type=='compare' || type=='composed' || type=='grouptotal2'">
                                    <label class="label margin-bottom-15 normal" for="points_variable">Variable de puntos</label>
                                    <input class="form-control typeahead" type="text" id="points_variable" name='points_variable'
                                           placeholder="Variable de puntos"
                                           value="{{ $goal->points_variable?$goal->pointsVariable->name.' (ID:'.$goal->points_variable.')':'' }}">
                                </div>

                            </div>
                            <br>
                            <div class="col-md-12 well" v-show="type=='compare' || type=='multiply' || type=='grouptotal'">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row form-group form-material">
                                            <label class="label margin-bottom-15 normal" for="variable1_id">Variable 1</label>
                                            <input class="form-control typeahead" type="text" id="variable1_id" name='variable1_id'
                                                   placeholder="Primera variable"
                                                   value="{{ $goal->variable1_id && $goal->variable1?$goal->variable1->name.' (ID:'.$goal->variable1_id.')':'' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-material empty" v-show="type=='compare' || type=='grouptotal'">
                                            <label class="label margin-bottom-15 normal" for="model">Operador</label>
                                            <select name="operator" id="operator" class="form-control">
                                                @foreach(\App\Manager\Challenges\Goal::getOperators() as $key=>$value)
                                                    <option {{ $goal->operator == $key?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            <div class="hint">Escoja el operador de comparación</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row form-group form-material">
                                            <label class="label margin-bottom-15 normal" for="variable2_id">Variable 2</label>
                                            <input class="form-control typeahead" type="text" id="variable2_id" name='variable2_id'
                                                   placeholder="Segunda variable"
                                                   value="{{ $goal->variable2_id && $goal->variable2?$goal->variable2->name.' (ID:'.$goal->variable2_id.')':'' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-show="type=='grouptotal'">
                                        <div class="form-group form-material floating">
                                            <input type="text" class="form-control" name="totalpercentage"
                                                   value="{{ old('totalpercentage',$goal->totalpercentage) }}"/>
                                            <div class="hint">Porcentaje de los puntos totales</div>
                                            <label class="floating-label" for="name">Porcentaje de asignación</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 well" v-show="type=='composed' || type=='grouptotal2'">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-material">
                                            <label class="" for="goals[]">Metas</label>
                                            @forelse(\App\Manager\Challenges\Goal::where('type','composed')->orWhere('type','compare')->orderBy('name')->get() as $gl)
                                                <span class="checkbox-custom checkbox-primary checkbox-lg"
                                                    @if($gl->type=='compare')
                                                        v-show="type=='composed'"
                                                    @elseif($gl->type=='composed')
                                                        v-show="type=='grouptotal2'"
                                                    @endif
                                                >
                                                    <input {{ ($goal->goals()->where('challenge_goals.id',$gl->id)->first())?'checked':'' }} type="checkbox"
                                                        id="goal_{{ $gl->id }}" name="goals[]" data-goalid="{{ $gl->id }}" value="{{ $gl->id }}"/>
                                                    <label for="goal_{{ $gl->id }}">{{ $gl->name }}</label>
                                                </span>
                                            @empty
                                                No hay metas para usar.
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-show="type=='grouptotal2' || type=='composed'">
                                        <div class="form-group form-material floating" v-show="type=='composed'">
                                            <input type="text" class="form-control" name="composednumber"
                                                   value="{{ old('composednumber',$goal->composednumber) }}"/>
                                            <div class="hint">Cantidad de metas a cumplir para alcanzar esta meta</div>
                                            <label class="floating-label" for="composednumber"># Metas a cumplir</label>
                                        </div>
                                        <div class="form-group form-material floating">
                                            <input type="text" class="form-control" name="totalpercentage"
                                                   value="{{ old('totalpercentage',$goal->totalpercentage) }}"/>
                                            <div class="hint">Porcentaje de los puntos totales</div>
                                            <label class="floating-label" for="name">Porcentaje de asignación</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="checkbox" id="active" name="active" data-plugin="switchery" {{ ($goal->active)?'checked':'' }} value="1" />
                            <label class="padding-top-3 margin-right-20" for="active" >Activa</label>
                            <button type="submit" class="btn btn-success"><i class="icon md-floppy"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function () {
        var elem = document.querySelector('#active');
        var init = new Switchery(elem);
        new Vue({
            el: '#app',
            data: {name: '', type: '', group: ''}
        });
        var variableSearch = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/search/variables/%QUERY',
                wildcard: '%QUERY'
            }
        });

        $('#variable1_id').typeahead(null, {
            name: 'variable1-search',
            display: 'name',
            source: variableSearch
        });
        $('#variable2_id').typeahead(null, {
            name: 'variable2-search',
            display: 'name',
            source: variableSearch
        });
        $('#points_variable').typeahead(null, {
            name: 'points_variable-search',
            display: 'name',
            source: variableSearch
        });
    });


</script>
