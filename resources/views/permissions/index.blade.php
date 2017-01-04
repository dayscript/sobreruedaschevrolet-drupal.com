@extends('layouts.app',['classes'=>'app-contacts'])

@section('title') Permisos @parent @endsection

@section('styles')
        <!-- Stylesheets -->
<link rel="stylesheet" href="/remark/material/global/css/bootstrap.min.css">
<link rel="stylesheet" href="/remark/material/global/css/bootstrap-extend.min.css">
<link rel="stylesheet" href="/remark/material/base/assets/css/site.min.css">
<!-- Plugins -->
<link rel="stylesheet" href="/remark/material/global/vendor/animsition/animsition.css">
<link rel="stylesheet" href="/remark/material/global/vendor/asscrollable/asScrollable.css">
<link rel="stylesheet" href="/remark/material/global/vendor/switchery/switchery.css">
<link rel="stylesheet" href="/remark/material/global/vendor/intro-js/introjs.css">
<link rel="stylesheet" href="/remark/material/global/vendor/slidepanel/slidePanel.css">
<link rel="stylesheet" href="/remark/material/global/vendor/flag-icon-css/flag-icon.css">
<link rel="stylesheet" href="/remark/material/global/vendor/waves/waves.css">
<link rel="stylesheet" href="/remark/material/global/vendor/filament-tablesaw/tablesaw.css">
<link rel="stylesheet" href="/remark/material/base/assets/examples/css/apps/contacts.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/basic.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">

<!-- Fonts -->
<link rel="stylesheet" href="/remark/material/global/fonts/material-design/material-design.min.css">
<link rel="stylesheet" href="/remark/material/global/fonts/brand-icons/brand-icons.min.css">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
<!--[if lt IE 9]>
<script src="/remark/material/global/vendor/html5shiv/html5shiv.min.js"></script>
<![endif]-->
<!--[if lt IE 10]>
<script src="/remark/material/global/vendor/media-match/media.match.min.js"></script>
<script src="/remark/material/global/vendor/respond/respond.min.js"></script>
<![endif]-->
<!-- Scripts -->
<script src="/remark/material/global/vendor/modernizr/modernizr.js"></script>
<script src="/remark/material/global/vendor/breakpoints/breakpoints.js"></script>
<script>
    Breakpoints();
</script>
@endsection

@section('scripts')
        <!-- Core  -->
<script src="/remark/material/global/vendor/jquery/jquery.js"></script>
<script src="/remark/material/global/vendor/bootstrap/bootstrap.js"></script>
<script src="/remark/material/global/vendor/animsition/animsition.js"></script>
<script src="/remark/material/global/vendor/asscroll/jquery-asScroll.js"></script>
<script src="/remark/material/global/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="/remark/material/global/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="/remark/material/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
<script src="/remark/material/global/vendor/waves/waves.js"></script>
<!-- Plugins -->
<script src="/remark/material/global/vendor/switchery/switchery.min.js"></script>
<script src="/remark/material/global/vendor/intro-js/intro.js"></script>
<script src="/remark/material/global/vendor/screenfull/screenfull.js"></script>
<script src="/remark/material/global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="/remark/material/global/vendor/filament-tablesaw/tablesaw.js"></script>
<script src="/remark/material/global/vendor/aspaginator/jquery.asPaginator.min.js"></script>
<script src="/remark/material/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="/remark/material/global/vendor/bootbox/bootbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>

<!-- Scripts -->
<script src="/remark/material/global/js/core.js"></script>
<script src="/remark/material/base/assets/js/site.js"></script>
<script src="/remark/material/base/assets/js/sections/menu.js"></script>
<script src="/remark/material/base/assets/js/sections/menubar.js"></script>
<script src="/remark/material/base/assets/js/sections/gridmenu.js"></script>
<script src="/remark/material/base/assets/js/sections/sidebar.js"></script>
<script src="/remark/material/global/js/configs/config-colors.js"></script>
<script src="/remark/material/base/assets/js/configs/config-tour.js"></script>
<script src="/remark/material/global/js/components/asscrollable.js"></script>
<script src="/remark/material/global/js/components/animsition.js"></script>
<script src="/remark/material/global/js/components/slidepanel.js"></script>
<script src="/remark/material/global/js/components/switchery.js"></script>
<script src="/remark/material/global/js/components/tabs.js"></script>
<script src="/remark/material/global/js/plugins/sticky-header.js"></script>
<script src="/remark/material/global/js/plugins/action-btn.js"></script>
<script src="/remark/material/global/js/plugins/selectable.js"></script>
<script src="/remark/material/global/js/components/aspaginator.js"></script>
<script src="/remark/material/global/js/components/animate-list.js"></script>
<script src="/remark/material/global/js/components/jquery-placeholder.js"></script>
<script src="/remark/material/global/js/components/material.js"></script>
<script src="/remark/material/global/js/components/selectable.js"></script>
<script src="/remark/material/global/js/components/bootbox.js"></script>
<script src="/remark/material/base/assets/js/app.js"></script>
<script src="/remark/material/base/assets/examples/js/apps/contacts.js"></script>
<script>
    $(document).ready(function () {
        new Vue({
            el: '#app',
            data: {
                usercheck: {}
            }
        });
    });

    $(document).on('click', '#deletePermissions', function (e) {
        if ($('.contacts-checkbox.selectable-item:checked').length) {
            bootbox.dialog({
                message: "¿Estás seguro que quieres eliminar este(s) permiso(s)?",
                buttons: {
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn-primary'
                    },
                    success: {
                        label: "Eliminar",
                        className: "btn-primary",
                        callback: function () {
                            $('.contacts-checkbox.selectable-item:checked').each(function () {
                                var id = $(this).data('permissionid');
                                $.post('/permissions/' + id, {'_token': '{{ csrf_token() }}', '_method': 'DELETE'}, function (data) {
                                    if (data == 'ok') {
                                        $('#permission_' + id).closest('tr').remove();
                                        toastr.success('Permiso eliminado!', '', {});
                                    } else {
                                        toastr.error(data, 'Error', {});
                                    }
                                });
                            });
                        }
                    }
                }
            });
        }

    });
</script>
@endsection

@section('content')
    @include('navbar.complete')
    @include('menubar.complete')
    <div class="page bg-white animsition">
        <!-- Contacts Content -->
        <div class="page-main">
            <!-- Contacts Content Header -->
            <div class="page-header">
                <h1 class="page-title">Lista de permisos</h1>
                <div class="page-header-actions">
                    <form>
                        <div class="input-search input-search-dark">
                            <i class="input-search-icon md-search" aria-hidden="true"></i>
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ $search or '' }}" >
                        </div>
                    </form>
                </div>
            </div>
            <!-- Contacts Content -->
            <div class="page-content page-content-table">
                <!-- Actions -->
                <div class="page-content-actions">
                    <div class="pull-right">
                            <form action="/permissions" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button id="deletePermissions" type="button" class="btn btn-danger btn-md empty-btn"><i class="icon md-delete"></i>Eliminar
                                </button>
                            </form>
                    </div>
                </div>
                <!-- Contacts -->
                <table class="table is-indent tablesaw" data-tablesaw-mode="stack" data-plugin="animateList"
                       data-animate="fade" data-child="tr" data-selectable="selectable">
                    <thead>
                    <tr>
                        <th class="pre-cell"></th>
                        <th class="cell-30" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">
                <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                  <input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"/>
                  <label for="select_all"></label>
                </span>
                        </th>
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Nombre</th>
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Modelo</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Permisos</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Opciones</th>
                        <th class="suf-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td class="pre-cell"></td>
                            <td class="cell-30">
                            <span class="checkbox-custom checkbox-primary checkbox-lg">
                              <input type="checkbox" class="contacts-checkbox selectable-item" id="permission_{{ $permission->id }}" data-permissionid="{{ $permission->id }}"/>
                              <label for="permission_{{ $permission->id }}"></label>
                            </span>
                            </td>
                            <td class="cell-300">
                                {{ $permission->name }}
                            </td>
                            <td class="cell-300">{{ \App\Manager\User\Permission::getModels()[$permission->model] }}</td>
                            <td>@foreach(\App\Manager\User\Permission::getOptions() as $key=>$option)
                                    @if($permission->$key)
                                        {{ $option }},
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-primary" data-url="/permissions/{{  $permission->id }}/edit" data-toggle="slidePanel">Editar</button>
                            </td>
                            <td class="suf-cell"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
    <!-- Site Action -->
    <button class="site-action btn-raised btn btn-success btn-floating" data-target="#addPermissionForm"
            data-toggle="modal" type="button">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
    <!-- End Site Action -->
    <!-- Add User Form -->
    <div class="modal fade" id="addPermissionForm" aria-hidden="true" aria-labelledby="addPermissionForm"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar Permiso</h4>
                </div>
                <form action="/permissions" method="post" role="form">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="name"/>
                            <div class="hint">Escriba el nombre del permiso</div>
                            <label class="floating-label margin-bottom-15" for="name">Nombre</label>
                        </div>
                        <div class="form-group form-material floating">
                            <textarea class="form-control maxlength-textarea mb-sm"  rows="3" name="description" maxlength="225" data-plugin="maxlength"></textarea>
                            <div class="hint">Descripción corta de este permiso.</div>
                            <label class="floating-label margin-bottom-15" for="description">Descripción</label>
                        </div>

                        <div class="form-group form-material empty ">
                            <label class="label margin-bottom-15" for="model">Modelo</label>
                            <select name="model" id="model" class="form-control">
                                @foreach(\App\Manager\User\Permission::getModels() as $key=>$model)
                                    <option value="{{ $key }}">{{ $model }}</option>
                                @endforeach
                            </select>
                            <div class="hint">Escoja el modelo de datos</div>
                        </div>
                        <div class="form-group form-material">
                            @foreach(\App\Manager\User\Permission::getOptions() as $key=>$option)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input type="checkbox" class="" id="{{ $key }}" name="{{ $key }}" value="{{ true }}"/>
                                    <label for="{{ $key }}">{{ $option }}</label>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-primary" type="submit">Agregar</button>
                        <a class="btn btn-sm btn-primary btn-pure" data-dismiss="modal" href="javascript:void(0)">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add User Form -->
    @include('footer.complete')
@endsection
