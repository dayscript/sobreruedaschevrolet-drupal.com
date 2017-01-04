@extends('layouts.app',['classes'=>'app-contacts'])

@section('title') Usuarios @parent @endsection

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
    <link rel="stylesheet" href="/remark/material/global/vendor/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/remark/material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">

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
    <script src="/remark/material/global/vendor/typeahead-js/bloodhound.min.js"></script>
    <script src="/remark/material/global/vendor/typeahead-js/typeahead.jquery.min.js"></script>
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
    {{--<script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
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
        $(document).on('click', '#deleteUsers', function (e) {
            if ($('.contacts-checkbox.selectable-item:checked').length) {
                bootbox.dialog({
                    message: "¿Estás seguro que quieres eliminar esto(s) usuario(s)?",
                    buttons: {
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-info'
                        },
                        success: {
                            label: "Eliminar",
                            className: "btn-danger",
                            callback: function () {
                                $('.contacts-checkbox.selectable-item:checked').each(function () {
                                    var id = $(this).data('userid');
                                    $.post('/users/' + id, {'_token': '{{ csrf_token() }}', '_method': 'DELETE'}, function (data) {
                                        if (data == 'ok') {
                                            $('#user_' + id).closest('tr').remove();
                                            toastr.success('Usuario eliminado!', '', {});
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
        $(document).on('click', '#deleteTrashedUsers', function (e) {
            if ($('.contacts-checkbox.selectable-item:checked').length) {
                bootbox.dialog({
                    message: "¿Estás seguro que quieres eliminar definitivamente esto(s) usuario(s)?",
                    buttons: {
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-info'
                        },
                        success: {
                            label: "Eliminar",
                            className: "btn-danger",
                            callback: function () {
                                $('.contacts-checkbox.selectable-item:checked').each(function () {
                                    var id = $(this).data('userid');
                                    $.post('/users/trashed/delete/' + id, {'_token': '{{ csrf_token() }}', '_method': 'POST'}, function (data) {
                                        if (data == 'ok') {
                                            $('#user_' + id).closest('tr').remove();
                                            toastr.success('Usuario eliminado!', '', {});
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
        $(document).on('click', '#restoreTrashedUsers', function (e) {
            if ($('.contacts-checkbox.selectable-item:checked').length) {
                bootbox.dialog({
                    message: "¿Estás seguro que quieres restaurar esto(s) usuario(s)?",
                    buttons: {
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-info'
                        },
                        success: {
                            label: "Restaurar",
                            className: "btn-success",
                            callback: function () {
                                $('.contacts-checkbox.selectable-item:checked').each(function () {
                                    var id = $(this).data('userid');
                                    $.post('/users/trashed/restore/' + id, {'_token': '{{ csrf_token() }}', '_method': 'POST'}, function (data) {
                                        if (data == 'ok') {
                                            $('#user_' + id).closest('tr').remove();
                                            toastr.success('Usuario restaurado!', '', {});
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
                                <a class="list-group-item" href="/users">
                                    <span class="item-right">{{ \App\User::count() }}</span><i class="icon md-accounts-list"
                                                                                               aria-hidden="true"></i> Todos los usuarios
                                </a>
                                @foreach(\App\User::statuses() as $key=>$value)
                                    <a class="list-group-item" href="/users/status/{{ $key }}">
                                        <span class="item-right">{{ \App\User::where('status',$key)->count() }}</span><i class="icon md-accounts-list"
                                                                                                                         aria-hidden="true"></i> Estado: {{ ucwords($value) }}
                                    </a>
                                @endforeach
                                <a class="list-group-item" href="/users/trashed">
                                    <span class="item-right">{{ \App\User::onlyTrashed()->count() }}</span><i class="icon md-delete"
                                                                                                              aria-hidden="true"></i> Usuarios eliminados
                                </a>
                            </div>
                        </div>
                        <div class="page-aside-section">
                            <h5 class="page-aside-title">Programas</h5>
                            <div class="list-group">
                                @foreach($programs as $pr)
                                    <a class="list-group-item" href="/users/program/{{ $pr->id }}">
                                        <span class="item-right">{{ $pr->users->count() }}</span>{{ $pr->name }}
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
                    Lista de usuarios
                    <small>{{ ($option=='trashed')?' - Eliminados ':($option=='program'?'Programa: ' . $program->name:'Todos') }}</small>
                </h1>
                <div class="page-header-actions">
                    <form>
                        <div class="input-search input-search-dark">
                            <i class="input-search-icon md-search" aria-hidden="true"></i>
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ $search or '' }}">
                            <input type="hidden" name="role" value="{{ $role or '' }}">
                            <input type="hidden" name="channel" value="{{ $channel or '' }}">
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
                            <form action="/users/deltrashed" method="post">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <button id="deleteTrashedUsers" type="button" class="btn btn-danger btn-md empty-btn"><i
                                            class="icon md-delete"></i>Eliminar definitivamente
                                </button>
                                <button id="restoreTrashedUsers" type="button" class="btn btn-primary btn-md empty-btn"><i
                                            class="icon md-edit"></i>Restaurar
                                </button>
                            </form>
                        @else
                            <form action="/users" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button id="deleteUsers" type="button" class="btn btn-danger btn-md empty-btn"><i class="icon md-delete"></i>Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="btn-group btn-group-flat">
                        @if($option=="program")
                            <div class="dropdown">
                                <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false" type="button"><i class="icon md-folder" aria-hidden="true"></i> Canal
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="{{ ($channel=='')?'active':'' }}"><a href="?role={{ $role }}&search={{ $search }}&channel=">Todos</a>
                                    </li>
                                    @php($label = 'Todos')
                                    @foreach($program->channels as $ch)
                                        @php
                                            if($channel==$ch->id)$label = $ch->name;
                                        @endphp
                                        <li class="{{ ($channel==$ch->id)?'active':'' }}"><a
                                                    href="?role={{ $role }}&search={{ $search }}&channel={{ $ch->id }}">{{ $ch->name }}</a></li>
                                    @endforeach
                                </ul>
                                : <span class="small text-info">{{ $label }}</span>

                            </div>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false" type="button"><i class="icon md-folder" aria-hidden="true"></i> Rol
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="{{ (Request::get('role','')=='')?'active':'' }}"><a href="?role=&search={{ $search }}&channel={{ $channel }}">Todos</a></li>
                                    @php($label = 'Todos')
                                    @foreach($program->roles as $rl)
                                        @php
                                            if($role==$rl->id)$label = $rl->name;
                                        @endphp
                                        <li class="{{ ($role==$rl->id)?'active':'' }}"><a
                                                    href="?role={{ $rl->id }}&search={{ $search }}&channel={{ $channel }}">{{ $rl->name }}</a></li>
                                    @endforeach
                                </ul>
                                : <span class="small text-info">{{ $label }}</span>
                            </div>
                        @endif
                        @if($option=="program")
                            <button class="btn btn-primary" data-url="/users/import/{{ $program->id }}" data-toggle="slidePanel">Importar</button>
                            @can('create',new \App\Manager\User\Goalvalue)
                                <button class="btn btn-primary" data-url="/users/liquidate/{{ $program->id }}" data-toggle="slidePanel">Liquidar
                                </button>
                            @endcan
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
                        <th></th>
                        <th class="" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Nombre</th>
                        <th class="" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Programas</th>
                        <th class="" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Roles / Estado</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Superior</th>
                        @if($option != 'trashed')
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Opciones</th>
                        @endif
                        <th class="suf-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $us)
                        <tr>
                            <td class="pre-cell"></td>
                            <td class="cell-30">
                            <span class="checkbox-custom checkbox-primary checkbox-lg">
                              <input type="checkbox" class="contacts-checkbox selectable-item" id="user_{{ $us->id }}" data-userid="{{ $us->id }}"/>
                              <label for="user_{{ $us->id }}"></label>
                            </span>
                            </td>
                            <td class="cell-30">
                                <a class="avatar" href="javascript:void(0)">
                                    <img class="img-responsive" src="{{ $us->avatar }}" alt="{{ $us->name }}">
                                </a>
                            </td>
                            <td class="">
                                {{ $us->name }}<br>
                                <small class="text-primary">{{ number_format($us->identification,0,',','.') }}</small>
                                <br>
                                <small class="text-primary">{{ $us->email }}</small>
                            </td>
                            <td class="">
                                @forelse($us->programs as $pr)
                                    <span class="text-info">{{ $pr->name }}</span><br>
                                @empty
                                    <span class="text-info">Sin programas asociados</span>
                                @endforelse
                            </td>
                            <td class="">{{ implode(', ',$us->roles->pluck('name')->toArray()) }}<br>
                                <span class="text-info">{{ \App\User::statuses()[$us->status] }}</span>
                            </td>
                            <td>
                                {!! $us->parent?$us->parent->name.'<br><small class="text-primary">'.number_format($us->parent->identification,0,',','.').'</small>':'' !!}
                            </td>
                            @if($option != 'trashed')
                                <td>
                                    @can('edit',$us)
                                        <button class="btn btn-sm btn-primary" data-url="/users/{{  $us->id }}/edit" data-toggle="slidePanel">Editar
                                        </button>
                                    @endcan
                                    @can('show',$us)
                                        <button class="btn btn-sm btn-primary" data-url="/users/{{  $us->id }}/variables"
                                                data-toggle="slidePanel">Variables
                                        </button>
                                        <button class="btn btn-sm btn-primary" data-url="/users/{{  $us->id }}/goals"
                                                data-toggle="slidePanel">Metas
                                        </button>
                                        <a href="/users/{{ $us->id }}" class="btn btn-sm btn-primary">Ver perfil</a>
                                    @endcan
                                </td>
                            @endif
                            <td class="suf-cell"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->appends(['search' => Request::get('search',''),'channel' => Request::get('channel',''), 'role' => Request::get('role','')])->links() }}
            </div>
        </div>
    </div>
    <!-- Site Action -->
    <button class="site-action btn-raised btn btn-success btn-floating" data-target="#addUserForm"
            data-toggle="modal" type="button">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
    <!-- End Site Action -->
    <!-- Add User Form -->
    <div class="modal fade" id="addUserForm" aria-hidden="true" aria-labelledby="addUserForm"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar Usuario</h4>
                </div>
                <form action="/users" method="post" role="form">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group form-material floating">
                            <input type="text" class="form-control" name="identification"/>
                            <div class="hint">Escriba la identificación (cédula) del usuario</div>
                            <label class="floating-label margin-bottom-15" for="identification">Identificación</label>
                        </div>
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="firstname"/>
                            <div class="hint">Escriba el nombre propio del usuario</div>
                            <label class="floating-label margin-bottom-15" for="firstname">Nombre propio</label>
                        </div>
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="lastname"/>
                            <div class="hint">Escriba los apellidos del usuario</div>
                            <label class="floating-label margin-bottom-15" for="lastname">Apellidos</label>
                        </div>
                        <div class="form-group form-material empty floating">
                            <input type="email" class="form-control" name="email" required/>
                            <div class="hint">Escriba la dirección de correo electrónico</div>
                            <label class="floating-label margin-bottom-15" for="email">Correo electrónico</label>
                        </div>
                        <div class="form-group form-material">
                            @foreach($programs as $pr)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input {{ ($option=="program" && $program->id==$pr->id)?'checked':'' }} type="checkbox" class=""
                                           id="program_{{ $pr->id }}" name="programs[]" data-programid="{{ $pr->id }}" value="{{ $pr->id }}"/>
                                    <label for="program_{{ $pr->id }}">{{ $pr->name }}</label>
                                </span>
                            @endforeach
                        </div>
                        <div class="form-group form-material">
                            <label class="" for="roles[]">Roles</label>
                            @foreach($roles as $role)
                                <span class="checkbox-custom checkbox-primary checkbox-lg">
                                    <input type="checkbox" class="" id="role_{{ $role->id }}" name="roles[]" data-roleid="{{ $role->id }}"
                                           value="{{ $role->id }}"/>
                                    <label for="role_{{ $role->id }}">{{ $role->name }}</label>
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
