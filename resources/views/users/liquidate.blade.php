<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Liquidar usuarios</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <p>A continuación se realiza la liquidación de los desafíos de cada usuario de este programa.
            </p>
            <div class="row">
                <div class="col-md-3">
                    <select name="period" id="period" class="form-control" v-model="date">
                        @foreach($dates as $date)
                            @if( $user->roles()->where('roles.id',1)->first() || $date >= date('Y-m-01'))
                                <option {{ $date==$dates[0]?'selected':'' }} value="{{ $date }}">{{ $date }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    <a id="processButton" class="btn btn-primary" href="#">Liquidar</a>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><h3 style="color:white;padding:10px">Registro de procesamiento</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 text-right"><strong>Progreso general</strong></div>
                                <div class="col-md-9">
                                    <div class="progress" style="height: 20px; margin-bottom: 10px;">
                                        <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 0%" role="progressbar" id="general-bar">
                                            <span class="sr-only">0% Complete</span>
                                        </div>
                                    </div>
                                    <div class="small text-info" id="log"></div>
                                </div>
                            </div>
                            @foreach($program->challenges as $challenge)
                                <hr>
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-1 text-right"><strong>{{ $challenge->name }}</strong></div>
                                    <div class="col-md-8">
                                        <div class="progress" style="height: 20px; margin-bottom: 10px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-warning active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 0%" role="progressbar" id="challengebar{{ $challenge->id }}">
                                                <span class="sr-only">0% Complete</span>
                                            </div>
                                        </div>
                                        <div class="small text-info" id="challengelog{{ $challenge->id }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    $(document).ready(function () {
        var vueapp = new Vue({
            el: '#app',
            data: {
                name: '',
                date: '{{ $dates[0] }}',
            }
        });
        $('#processButton').on('click', function () {
            var progress = 0;
            var points = 0;
            $('.progress-bar').css('width', progress + '%');
            $('.progress-bar').addClass('active');
            $('#general-bar').removeClass('progress-bar-success');
            $('#log').html('Iniciando procesamiento...<br>');
            $('#log').html('Actualizando variables calculadas...<br>');
            $.ajax('/users/processvariables/{{ $program->id }}/' + vueapp.date, {
                async: false
            }).success(function (data) {
                $('#log').html(data.messages);
                progress += 10;
                $('#general-bar').css('width', progress + '%');
            });
            var ch_progress = {{ 90/$program->challenges->count() }};
            @foreach($program->challenges as $challenge)
            $('#log').html('Procesando Desafío: <span class="text-info">{{ $challenge->name }}</span><br>');
            $('#challengelog{{ $challenge->id }}').html('Iniciando procesamiento...');
            $('#challengebar{{ $challenge->id }}').css('width', '10%');
            $.ajax('/users/processliquidate/{{ $challenge->id }}/' + vueapp.date, {
                async: true
            }).success(function (data) {
                $('#challengelog{{ $challenge->id }}').html(data.messages);
                progress += ch_progress;
                points += parseInt(data.messages[1].replace('Puntos: <span class="text-info">','').replace('</span>',''));
                if (Math.round(progress) >= 100) {
                    $('#log').html('Liquidación completada. <strong>Total de Puntos: '+ points +'</strong>');
                    $('.progress-bar').removeClass('active');
                    $('#general-bar').addClass('progress-bar-success');
                }
                $('#general-bar').css('width', progress + '%');
                $('#challengebar{{ $challenge->id }}').css('width', '100%');

            });
            @endforeach
        });
    });

</script>
