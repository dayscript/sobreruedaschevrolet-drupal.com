<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Editar desafío: @{{ name }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <form action="/challenges/{{ $challenge->id }}" method="post" autocomplete="off">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" v-model="name" name="name" value="{{ old('name',$challenge->name) }}"/>
                            <div class="hint">Escriba el nombre del desafío</div>
                            <label class="floating-label" for="name">Nombre </label>
                        </div>
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" name="description" value="{{ old('description',$challenge->description) }}"/>
                            <div class="hint">Escriba la descripción</div>
                            <label class="floating-label" for="email">Descripción</label>
                        </div>
                        <div class="form-group form-material empty ">
                            <label class="label margin-bottom-15 normal" for="model">Programa</label>
                            <select name="program" id="program" class="form-control">
                                @foreach($programs as $pr)
                                    <option {{ $challenge->program_id == $pr->id?'selected':'' }} value="{{ $pr->id }}">{{ $pr->name }}</option>
                                @endforeach
                            </select>
                            <div class="hint">Escoja el programa</div>
                        </div>
                        <hr>
                        <div class="form-group form-material">
                            <label class="" for="channels[]">Canales</label>
                            @foreach($channels as $channel)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($challenge->channels()->where('program_channels.id',$channel->id)->first())?'checked':'' }} type="checkbox" class=""
                                           id="channel_{{ $channel->id }}" name="channels[]" data-channelid="{{ $channel->id }}"
                                           value="{{ $channel->id }}"/>
                                    <label for="channel_{{ $channel->id }}">{{ $channel->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <hr>
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
