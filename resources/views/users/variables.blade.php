<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Variables del usuario: {{ $us->firstname }} {{ $us->lastname }}</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <div class="form-group">
                <select name="period" id="period" class="form-control">
                    <option value="">Escoja un periodo...</option>
                    @foreach(\App\Manager\User\Value::getUsedDates() as $date)
                        <option value="{{ $date }}">{{ substr($date,0,7) }}</option>
                    @endforeach
                </select>
            </div>
            <p>Estos son los valores de las variables cargados para este usuario</p>
            <table class="table table-striped table-hover">
                <tbody>
                @forelse($us->values as $value)
                    @if($value->variable)
                        <tr class="valuerow {{ $value->period }}" style="display: none;">
                            <td>{{ $value->period }}</td>
                            <td>{{ $value->variable?$value->variable->name:'' }}</td>
                            <td>{{ $value->value }}</td>
                        </tr>
                    @else
                        @php($value->delete())
                    @endif
                @empty
                    <tr>
                        <td>No hay valores cargados para este usuario</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </section>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#period').on('change', function(){
            var period = $(this).val();
            $('.valuerow:not(.'+period+')').hide();
            $('.valuerow.'+period).show();
        });
    });
</script>