@extends('layouts.app',['classes'=>'app-contacts'])

@section('title') Metas @parent @endsection

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

        $(document).on('click', '#deleteGoals', function (e) {
            if ($('.contacts-checkbox.selectable-item:checked').length) {
                bootbox.dialog({
                    message: "¿Estás seguro que quieres eliminar esta(s) meta(s)?",
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
                                    var id = $(this).data('goalid');
                                    $.post('/goals/' + id, {'_token': '{{ csrf_token() }}', '_method': 'DELETE'}, function (data) {
                                        if (data == 'ok') {
                                            $('#goal_' + id).closest('tr').remove();
                                            toastr.success('Meta eliminada!', '', {});
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
        $(document).on('click', '#deleteTrashedGoals', function (e) {
            if ($('.contacts-checkbox.selectable-item:checked').length) {
                bootbox.dialog({
                    message: "¿Estás seguro que quieres eliminar definitivamente esta(s) meta(s)?",
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
                                    var id = $(this).data('goalid');
                                    $.post('/goals/trashed/delete/' + id, {'_token': '{{ csrf_token() }}', '_method': 'POST'}, function (data) {
                                        if (data == 'ok') {
                                            $('#goal_' + id).closest('tr').remove();
                                            toastr.success('Meta eliminada!', '', {});
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
        $(document).on('click', '#restoreTrashedGoals', function (e) {
            if ($('.contacts-checkbox.selectable-item:checked').length) {
                bootbox.dialog({
                    message: "¿Estás seguro que quieres restaurar esta(s) meta(s)?",
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
                                    var id = $(this).data('goalid');
                                    $.post('/goals/trashed/restore/' + id, {'_token': '{{ csrf_token() }}', '_method': 'POST'}, function (data) {
                                        if (data == 'ok') {
                                            $('#goal_' + id).closest('tr').remove();
                                            toastr.success('Meta restaurada!', '', {});
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
                                <a class="list-group-item" href="/goals">
                                    <span class="item-right">{{ \App\Manager\Challenges\Goal::count() }}</span><i class="icon md-accounts-list"
                                                                                                                  aria-hidden="true"></i> Todas las metas
                                </a>
                                @foreach(\App\Manager\Challenges\Goal::getTypes() as $key=>$value)
                                    <a class="list-group-item" href="/goals/type/{{ $key }}">
                                        <span class="item-right">{{ \App\Manager\Challenges\Goal::where('type',$key)->count() }}</span><i
                                                class="icon md-accounts-list"
                                                aria-hidden="true"></i> Tipo: {{ ucwords($value) }}
                                    </a>
                                @endforeach
                                <a class="list-group-item" href="/goals/trashed">
                                    <span class="item-right">{{ \App\Manager\Challenges\Goal::onlyTrashed()->count() }}</span><i
                                            class="icon md-delete"
                                            aria-hidden="true"></i> Metas eliminadas
                                </a>
                            </div>
                        </div>
                        <div class="page-aside-section">
                            <h5 class="page-aside-title">Programas</h5>
                            <div class="list-group">
                                @foreach($programs as $pr)
                                    <a class="list-group-item" href="/goals/program/{{ $pr->id }}">
                                        <span class="item-right">{{ $pr->goals->count() }}</span>{{ $pr->name }}
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
                    Lista de metas
                    <small>{{ ($option=='trashed')?' - Eliminadas ':($option=='program'?'Programa: ' . $program->name:'Todos') }}</small>
                </h1>
                <div class="page-header-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group btn-group-flat">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false" type="button"><i class="icon md-check" aria-hidden="true"></i> Estado
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        @php($options = ['1'=>'Activas','0'=>'Inactivas'])
                                        @foreach($options as $key=>$lb)
                                            @php
                                                if($active==$key)$label = $lb;
                                            @endphp
                                            <li class="{{ ($active==$key)?'active':'' }}"><a href="?active={{ $key }}&search={{ $search }}">{{ $lb }}</a></li>
                                        @endforeach
                                    </ul>: <span class="small text-info">{{ $label }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form>
                                <div class="input-search input-search-dark">
                                    <i class="input-search-icon md-search" aria-hidden="true"></i>
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ $search or '' }}">
                                    <input type="hidden" name="active" value="{{ $active or 1 }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contacts Content -->
            <div class="page-content page-content-table">
                <!-- Actions -->
                <div class="page-content-actions">
                    <div class="pull-right">
                        @if($option=="trashed")
                            <form action="/goals/deltrashed" method="post">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <button id="deleteTrashedGoals" type="button" class="btn btn-danger btn-md empty-btn"><i
                                            class="icon md-delete"></i>Eliminar definitivamente
                                </button>
                                <button id="restoreTrashedGoals" type="button" class="btn btn-primary btn-md empty-btn"><i class="icon md-edit"></i>Restaurar
                                </button>
                            </form>
                        @else
                            <form action="/goals" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button id="deleteGoals" type="button" class="btn btn-danger btn-md empty-btn"><i class="icon md-delete"></i>Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                        @foreach(\App\Manager\Challenges\Goal::getTypes() as $type=>$label)
                            <div>
                                <strong>{{ $label }}:</strong> {{ \App\Manager\Challenges\Goal::getTypeDescription($type) }}
                            </div>
                        @endforeach
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
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Nombre / Desafío</th>
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Roles</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Tipo</th>
                        @if($option != 'trashed')
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Opciones</th>
                        @endif
                        <th class="suf-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($goals as $goal)
                        <tr>
                            <td class="pre-cell"></td>
                            <td class="cell-30">
                            <span class="checkbox-custom checkbox-primary checkbox-lg">
                              <input type="checkbox" class="contacts-checkbox selectable-item" id="goal_{{ $goal->id }}"
                                     data-goalid="{{ $goal->id }}"/>
                              <label for="goal_{{ $goal->id }}"></label>
                            </span>
                            </td>
                            <td class="cell-300">
                                {{ $goal->name }}<br>
                                <small class="text-info">{{ $goal->challenge_id?$goal->challenge->name:'-' }}</small>
                            </td>
                            <td class="cell-300">{{ $goal->role_id?$goal->role->name:'-' }}<br>
                                <small class="text-info">{{ $goal->group?'Grupal':'Individual' }}</small>
                            </td>
                            <td>{{ $goal->typeLabel() }}<br>
                                @if($goal->type == 'compare')
                                    <span class="small text-info">{{ $goal->variable1_id && $goal->variable1?$goal->variable1->name:'' }}</span>
                                    <span class="small text-primary"><strong>{{ $goal->operator?$goal->operator:'' }}</strong></span>
                                    <span class="small text-info">{{ $goal->variable2_id&& $goal->variable2?$goal->variable2->name:'' }}</span>
                                @elseif($goal->type == 'multiply')
                                    <span class="small text-info">{{ $goal->variable1_id && $goal->variable1?$goal->variable1->name:'' }}</span>
                                    <span class="small text-primary"><strong>*</strong></span>
                                    <span class="small text-info">{{ $goal->variable2_id && $goal->variable2?$goal->variable2->name:'' }}</span>
                                @elseif($goal->type == 'grouptotal')
                                    <span class="small text-info">{{ $goal->variable1_id && $goal->variable1?$goal->variable1->name:'' }}</span>
                                    <span class="small text-primary"><strong>{{ $goal->operator?$goal->operator:'' }}</strong></span>
                                    <span class="small text-info">{{ $goal->variable2_id && $goal->variable2?$goal->variable2->name:'' }}</span>
                                @elseif($goal->type == 'composed')
                                    <span class="small text-info">{!! implode('<br>',$goal->goals->pluck('name')->toArray())  !!}</span>
                                @endif
                            </td>
                            @if($option != 'trashed')
                                <td>
                                    <button class="btn btn-primary" data-url="/goals/{{  $goal->id }}/edit" data-toggle="slidePanel">Editar</button>
                                </td>
                            @endif
                            <td class="suf-cell"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $goals->appends(['search' => $search,'active' => $active])->links() }}
            </div>
        </div>
    </div>
    <!-- Site Action -->
    <button class="site-action btn-raised btn btn-success btn-floating" data-target="#addGoalForm"
            data-toggle="modal" type="button">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
    <!-- End Site Action -->
    <!-- Add User Form -->
    <div class="modal fade" id="addGoalForm" aria-hidden="true" aria-labelledby="addGoalForm"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar Meta</h4>
                </div>
                <form action="/goals" method="post" role="form">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group form-material empty floating">
                            <input type="text" class="form-control" name="name"/>
                            <div class="hint">Escriba el nombre de la goal</div>
                            <label class="floating-label margin-bottom-15" for="name">Nombre</label>
                        </div>
                        <div class="form-group form-material empty ">
                            <label class="label margin-bottom-15 normal" for="model">Desafío</label>
                            <select name="challenge" id="challenge" class="form-control">
                                @foreach($challenges as $ch)
                                    <option value="{{ $ch->id }}">{{ $ch->name }}</option>
                                @endforeach
                            </select>
                            <div class="hint">Escoja el Desafío</div>
                        </div>
                        <div class="form-group form-material empty ">
                            <label class="label margin-bottom-15 normal" for="model">Tipo</label>
                            <select name="type" id="type" class="form-control">
                                @foreach(\App\Manager\Challenges\Goal::getTypes() as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="hint">Escoja un tipo</div>
                        </div>
                        <hr>
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
