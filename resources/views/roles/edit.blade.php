<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar rol: @{{ name }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <form action="/roles/{{ $role->id }}" method="post" autocomplete="off">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$role->name) }}"/>
                            <div class="hint">Escriba el nombre del rol</div>
                            <label class="floating-label" for="name">Nombre </label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" name="description" value="{{ old('description',$role->description) }}"/>
                            <div class="hint">Escriba la descripción</div>
                            <label class="floating-label" for="email">Descripción</label>
                        </div>
                        <div class="form-group form-material">
                            <label for="">Programas</label>
                            @foreach($programs as $program)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($role->programs()->where('programs.id',$program->id)->first())?'checked':'' }} type="checkbox" class="" id="program_{{ $program->id }}" name="programs[]" data-programid="{{ $program->id }}" value="{{ $program->id }}"/>
                                    <label for="program_{{ $program->id }}">{{ $program->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <hr>
                        <div class="form-group form-material">
                            <label for="">Permisos</label>
                            @foreach($permissions as $permission)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($role->permissions()->where('permissions.id',$permission->id)->first())?'checked':'' }} type="checkbox" class="" id="permission_{{ $permission->id }}" name="permissions[]" data-permissionid="{{ $permission->id }}" value="{{ $permission->id }}"/>
                                    <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
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
