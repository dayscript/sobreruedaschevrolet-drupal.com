<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar permiso: @{{ name }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <form action="/permissions/{{ $permission->id }}" method="post" autocomplete="off">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$permission->name) }}"/>
                            <div class="hint">Escriba el nombre del rol</div>
                            <label class="floating-label" for="name">Nombre </label>
                        </div>
                        <div class="form-group form-material floating">
                            <textarea class="form-control {{ old('description',$permission->description)?old('description',$permission->description):'empty' }}"
                              rows="3" name="description">{{ old('description',$permission->description) }}</textarea>
                            <div class="hint">Describa este permiso en pocas palabras.</div>
                            <label class="floating-label" for="description">Descripción</label>
                        </div>
                        <div class="form-group form-material empty ">
                            <label class="label margin-bottom-15 normal" for="model">Modelo</label>
                            <select name="model" id="model" class="form-control">
                                @foreach(\App\Manager\User\Permission::getModels() as $key=>$model)
                                    <option {{ $permission->model == $key?'selected':'' }} value="{{ $key }}">{{ $model }}</option>
                                @endforeach
                            </select>
                            <div class="hint">Escoja el modelo de datos</div>
                        </div>
                        <div class="form-group form-material">
                            @foreach(\App\Manager\User\Permission::getOptions() as $key=>$option)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ $permission->$key?'checked':'' }} type="checkbox" class="" id="{{ $key }}" name="{{ $key }}" value="{{ true }}"/>
                                    <label for="{{ $key }}">{{ $option }}</label>
                                </span>
                            @endforeach
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
        new Vue({
            el: '#app',
            data: {name: ''}
        });});

</script>
