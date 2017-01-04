<div>
    <header class="slidePanel-header">
        <div class="overlay-top overlay-panel overlay-background bg-light-blue-600">
            <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
            </div>
            <h4 class="stage-name">Importar usuarios</h4>
        </div>
    </header>
    <div class="slidePanel-inner">
        <section class="slidePanel-inner-section">
            <p>Puede importar un archivo con la información de usuarios. La primera fila del excel debe contener los nombres de los campos a cargar.
                Este importador solo procesa la primera hoja encontrada en el archivo de Excel.
                <br>Recuerde que puede personalizar estos campos en la configuración del programa.
            </p>
            <p class="well"><strong>Nota:</strong> Para importar usuarios, puede usar la siguiente plantilla de excel como base para alimentar la información.
                <br>
                <a class="btn btn-primary btn-sm" href="/import_templates/users/download">Plantilla de carga de usuarios</a>
            </p>
            @if($templates = \App\Manager\User\ImportTemplate::all())
                <p class="well"><strong>Nota:</strong> Esta(s) plantilla(s) de carga está(n) disponibles para su perfil, puede descargar y usarla(s) como base para alimentar la información.
                    <br>
                    @foreach($templates as $template)
                        <a class="btn btn-primary btn-sm" href="/import_templates/{{ $template->id }}/download">{{ $template->name }}</a>
                    @endforeach
                </p>
            @else

            @endif
            <div class="row">
                <div class="col-md-12">
                    <form id="myId" action="/users/processimport/{{ $program->id }}" class="dropzone" method="post">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                    </form>
                </div>
                <div class="panel col-md-12">
                    <div class="panel-body" id="log">
                        <h3>Registro de carga</h3>
                    </div>
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
        });
        Dropzone.options.myId = {
            paramName: 'file',
            maxFileSize: 4,
            uploadMultiple: false,
            acceptedFiles: '.xls, .xlsx',
            dictDefaultMessage: 'Arrastre o haga click aquí para cargar un archivo de excel',
            dictFallbackMessage: 'Su navegador no soporta la funcionalidad de arrastrar y soltar',
            init: function () {
                this.on("queuecomplete", function (file) {
//                    location.reload();
                });
            }
        };
        var myDropzone = new Dropzone("#myId");
        myDropzone.on("success", function (file, data) {
//            if(data.created.length)toastr.success(data.created.length + ' usuarios creados', '', {});
//            if(data.exists.length)toastr.info(data.exists.length + ' usuarios ya existían', '', {});
//            if(data.trashed.length)toastr.error(data.trashed.length + ' usuarios existen en la papelera', '', {});
//            if(data.errors.length)toastr.error(data.errors.length + ' usuarios con errores', '', {});
//            $('#log').append('<br><b>Creados:</b> ' + data.created.length);
//            $('#log').append('<br><b>Errores:</b> ' + data.errors.length);
//            $('#log').append('<br><b>Ya existentes:</b> ' + data.exists.length);
//            $('#log').append('<br><b>En la papelera:</b> ' + data.trashed.length);
            $('#log').append( data.messages);
            myDropzone.removeFile(file);
        });
    });

</script>
