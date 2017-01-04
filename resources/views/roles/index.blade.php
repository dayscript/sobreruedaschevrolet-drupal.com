@extends('layouts.app',['classes'=>'app-contacts'])

@section('title') Roles @parent @endsection

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

    $(document).on('click', '#deleteRoles', function (e) {
        if ($('.contacts-checkbox.selectable-item:checked').length) {
            bootbox.dialog({
                message: "¿Estás seguro que quieres eliminar esto(s) rol(es)?",
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
                                var id = $(this).data('roleid');
                                $.post('/roles/' + id, {'_token': '{{ csrf_token() }}', '_method': 'DELETE'}, function (data) {
                                    if (data == 'ok') {
                                        $('#role_' + id).closest('tr').remove();
                                        toastr.success('Rol eliminado!', '', {});
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
    $(document).on('click', '#deleteTrashedRoles', function (e) {
        if ($('.contacts-checkbox.selectable-item:checked').length) {
            bootbox.dialog({
                message: "¿Estás seguro que quieres eliminar definitivamente esto(s) rol(es)?",
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
                                var id = $(this).data('roleid');
                                $.post('/roles/trashed/delete/' + id, {'_token': '{{ csrf_token() }}', '_method': 'POST'}, function (data) {
                                    if (data == 'ok') {
                                        $('#role_' + id).closest('tr').remove();
                                        toastr.success('Rol eliminado!', '', {});
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
    $(document).on('click', '#restoreTrashedRoles', function (e) {
        if ($('.contacts-checkbox.selectable-item:checked').length) {
            bootbox.dialog({
                message: "¿Estás seguro que quieres restaurar esto(s) rol(es)?",
                buttons: {
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn-primary'
                    },
                    success: {
                        label: "Restaurar",
                        className: "btn-primary",
                        callback: function () {
                            $('.contacts-checkbox.selectable-item:checked').each(function () {
                                var id = $(this).data('roleid');
                                $.post('/roles/trashed/restore/' + id, {'_token': '{{ csrf_token() }}', '_method': 'POST'}, function (data) {
                                    if (data == 'ok') {
                                        $('#role_' + id).closest('tr').remove();
                                        toastr.success('Rol restaurado!', '', {});
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
        <div class="page-aside">
            <!-- Contacts Sidebar -->
            <div class="page-aside-switch">
                <i class="icon md-chevron-left" aria-hidden="true"></i>
                <i class="icon md-chevron-right" aria-hidden="true"></i>
            </div>
            <div class="page-aside-inner" data-plugin="pageAsideScroll">
                <div data-role="container">
                    <div data-role="content">
                        <div class="page-aside-section">
                            <div class="list-group">
                                <a class="list-group-item" href="/roles">
                                    <span class="item-right">{{ \App\Manager\User\Role::count() }}</span><i class="icon md-accounts-list"
                                                                                               aria-hidden="true"></i> Todos los roles
                                </a>
                                <a class="list-group-item" href="/roles/trashed">
                                    <span class="item-right">{{ \App\Manager\User\Role::onlyTrashed()->count() }}</span><i class="icon md-delete"
                                                                                                              aria-hidden="true"></i> Roles eliminados
                                </a>
                            </div>
                        </div>
                        <div class="page-aside-section">
                            <h5 class="page-aside-title">Programas</h5>
                            <div class="list-group">
                                @foreach($programs as $pr)
                                    <a class="list-group-item" href="/roles/program/{{ $pr->id }}">
                                        <span class="item-right">{{ $pr->roles->count() }}</span>{{ $pr->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contacts Content -->
        <div class="page-main">
            <!-- Contacts Content Header -->
            <div class="page-header">
                <h1 class="page-title">
                    Lista de roles <small>{{ ($option=='trashed')?' - Eliminados ':($option=='program'?'Programa: ' . $program->name:'Todos') }}</small>
                </h1>
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
                        @if($option=="trashed")
                            <form action="/roles/deltrashed" method="post">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <button id="deleteTrashedRoles" type="button" class="btn btn-danger btn-md empty-btn"><i
                                            class="icon md-delete"></i>Eliminar definitivamente
                                </button>
                                <button id="restoreTrashedRoles" type="button" class="btn btn-primary btn-md empty-btn"><i class="icon md-edit"></i>Restaurar
                                </button>
                            </form>
                        @else
                            <form action="/roles" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button id="deleteRoles" type="button" class="btn btn-danger btn-md empty-btn"><i class="icon md-delete"></i>Eliminar
                                </button>
                            </form>
                        @endif
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
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Programas</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Descripción</th>
                        @if($option != 'trashed')
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Opciones</th>
                        @endif
                        <th class="suf-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $rl)
                        <tr>
                            <td class="pre-cell"></td>
                            <td class="cell-30">
                            <span class="checkbox-custom checkbox-primary checkbox-lg">
                              <input type="checkbox" class="contacts-checkbox selectable-item" id="role_{{ $rl->id }}" data-roleid="{{ $rl->id }}"/>
                              <label for="role_{{ $rl->id }}"></label>
                            </span>
                            </td>
                            <td class="cell-300">
                                {{ $rl->name }}
                            </td>
                            <td class="cell-300">{{ implode(', ',$rl->programs->pluck('name')->toArray()) }}</td>
                            <td>{{ $rl->description}}</td>
                            @if($option != 'trashed')
                                <td>
                                    <button class="btn btn-primary" data-url="/roles/{{  $rl->id }}/edit" data-toggle="slidePanel">Editar</button>
                                </td>
                            @endif
                            <td class="suf-cell"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    <!-- Site Action -->
    <button class="site-action btn-raised btn btn-success btn-floating" data-target="#addRoleForm"
            data-toggle="modal" type="button">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
    <!-- End Site Action -->
    <!-- Add User Form -->
    <div class="modal fade" id="addRoleForm" aria-hidden="true" aria-labelledby="addRoleForm"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar Rol</h4>
                </div>
                <form action="/roles" method="post" role="form">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="name"/>
                            <div class="hint">Escriba el nombre del rol</div>
                            <label class="floating-label margin-bottom-15" for="name">Nombre</label>
                        </div>
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="description" />
                            <div class="hint">Escriba la descripción</div>
                            <label class="floating-label margin-bottom-15" for="email">Descripción</label>
                        </div>
                        <div class="form-group form-material">
                            <label for="">Programas</label>
                            @foreach($programs as $pr)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($option == "program" && $program->id== $pr->id)?'checked':'' }} type="checkbox" class="" id="program_{{ $pr->id }}" name="programs[]" data-programid="{{ $pr->id }}" value="{{ $pr->id }}"/>
                                    <label for="program_{{ $pr->id }}">{{ $pr->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <hr>
                        <div class="form-group form-material">
                            <label for="">Permisos</label>
                            @foreach($permissions as $permission)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input  type="checkbox" class="" id="permission_{{ $permission->id }}" name="permissions[]" data-permissionid="{{ $permission->id }}" value="{{ $permission->id }}"/>
                                    <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
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
