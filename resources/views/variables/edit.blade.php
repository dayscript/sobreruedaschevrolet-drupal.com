<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar variable: @{{ name }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="row">
                <div class="col-md-12">
                    <form action="/variables/{{ $variable->id }}" method="post" autocomplete="off">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$variable->name) }}"/>
                                    <div class="hint">Escriba el nombre de la variable</div>
                                    <label class="floating-label" for="name">Nombre </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material empty ">
                                    <label class="label margin-bottom-15 normal" for="model">Programa</label>
                                    <select name="program" id="program" class="form-control">
                                        @foreach($programs as $pr)
                                            <option {{ $variable->program_id == $pr->id?'selected':'' }} value="{{ $pr->id }}">{{ $pr->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="hint">Escoja el programa</div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group form-material empty ">
                                    <label class="label margin-bottom-15 normal" for="model">Tipo de variable</label>
                                    <select name="type" id="type" class="form-control" v-model="type">
                                        @foreach(\App\Manager\Challenges\Variable::getTypes() as $key=>$value)
                                            <option {{ $variable->type == $key?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="hint">Escoja el Tipo</div>
                                </div>
                            </div>
                            <div class="col-md-4" v-show="type=='constant'">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" name="constant_value"
                                           value="{{ old('constant_value',$variable->constant_value) }}"/>
                                    <div class="hint">Valor de esta constante en el sistema</div>
                                    <label class="floating-label" for="constant_value">Valor</label>
                                </div>
                            </div>
                            <div class="col-md-6" v-show="type=='percentage' || type=='simpleincrement' || type=='multiply'">
                                <div class="form-group form-material">
                                    <label class="label margin-bottom-15 normal" for="variable1_id" v-show="type=='simpleincrement'">Variable</label>
                                    <label class="label margin-bottom-15 normal" for="variable1_id" v-show="type=='percentage'">Variable Base (100%)</label>
                                    <label class="label margin-bottom-15 normal" for="variable1_id" v-show="type=='multiply'">Variable 1</label>
                                    <input class="form-control typeahead" type="text" id="variable1_id" name='variable1_id'
                                           placeholder="Variable asociada"
                                           value="{{ $variable->variable1_id?$variable->variable1->name.' (ID:'.$variable->variable1_id.')':'' }}">
                                </div>
                            </div>
                            <div class="col-md-6" v-show="type=='percentage' || type=='multiply'">
                                <div class="form-group form-material">
                                    <label class="label margin-bottom-15 normal" for="variable2_id" v-show="type=='percentage'">Variable a calcular</label>
                                    <label class="label margin-bottom-15 normal" for="variable1_id" v-show="type=='multiply'">Variable 2</label>
                                    <input class="form-control typeahead" type="text" id="variable2_id" name='variable2_id'
                                           placeholder="Variable asociada"
                                           value="{{ $variable->variable2_id?$variable->variable2->name.' (ID:'.$variable->variable2_id.')':'' }}">
                                </div>
                            </div>
                        </div>
                        <br>
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
        new Vue({
            el: '#app',
            data: {name: '', type: ''}
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
    });

</script>
