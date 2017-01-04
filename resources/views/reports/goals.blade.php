@extends('layouts.app',['classes'=>'app-contacts'])

@section('title') Reporte de Metas @parent @endsection

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
                <h1 class="page-title">Reporte de Metas</h1>
                <div class="page-header-actions">
                    <a href="/reports/goals/export?date={{ $date }}&goal={{ $goal }}&supervisor={{ $supervisor }}&channel={{ $channel }}" class="btn btn-primary">Exportar</a>
                </div>
            </div>
            <!-- Contacts Content -->
            <div class="page-content page-content-table">
                <!-- Actions -->
                <div class="page-content-actions">
                    <div class="btn-group btn-group-flat">
                        <div class="dropdown">
                            <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false" type="button"><i class="icon md-calendar" aria-hidden="true"></i> Periodo
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li class="{{ ($date=='')?'active':'' }}"><a href="?date=&goal={{ $goal }}&supervisor={{ $supervisor }}&channel={{ $channel }}">Todos</a></li>
                                @php($label = 'Todos')
                                @foreach(\App\Manager\User\Goalvalue::getUsedDates() as $dt)
                                    @php
                                        if($date==$dt)$label = substr($dt,0,7);
                                    @endphp
                                    <li class="{{ ($date==$dt)?'active':'' }}"><a href="?date={{ $dt }}&goal={{ $goal }}&supervisor={{ $supervisor }}&channel={{ $channel }}">{{ substr($dt,0,7) }}</a></li>
                                @endforeach
                            </ul>: <span class="small text-info">{{ $label }}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false" type="button"><i class="icon md-assignment-check" aria-hidden="true"></i> Meta
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li class="{{ ($goal=='')?'active':'' }}"><a href="?date={{ $date }}&goal=&supervisor={{ $supervisor }}&channel={{ $channel }}">Todas</a></li>
                                @php($label = 'Todas')
                                @foreach($goals as $gl)
                                    @php
                                        if($goal==$gl->id)$label = $gl->name;
                                    @endphp
                                    <li class="{{ ($goal==$gl->id)?'active':'' }}"><a href="?date={{ $date }}&goal={{ $gl->id }}&supervisor={{ $supervisor }}&channel={{ $channel }}">{{ $gl->name }}</a></li>
                                @endforeach
                            </ul>: <span class="small text-info">{{ $label }}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false" type="button"><i class="icon md-account-box" aria-hidden="true"></i> Supervisor
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li class="{{ ($supervisor=='')?'active':'' }}"><a href="?date={{ $date }}&goal={{ $goal}}&supervisor=&channel={{ $channel }}">Todos</a></li>
                                @php($label = 'Todos')
                                @foreach($supervisors as $sp)
                                    @php
                                        if($supervisor==$sp->id)$label = $sp->name;
                                    @endphp
                                    <li class="{{ ($supervisor==$sp->id)?'active':'' }}"><a href="?date={{ $date }}&goal={{ $goal}}&supervisor={{ $sp->id }}&channel={{ $channel }}">{{ $sp->name }}</a></li>
                                @endforeach
                            </ul>: <span class="small text-info">{{ $label }}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-pure btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false" type="button"><i class="icon md-code-setting" aria-hidden="true"></i> Canal
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li class="{{ ($channel=='')?'active':'' }}"><a href="?date={{ $date }}&goal={{ $goal}}&supervisor={{ $supervisor }}&channel=">Todos</a></li>
                                @php($label = 'Todos')
                                @foreach($channels as $ch)
                                    @php
                                        if($channel==$ch->id)$label = $ch->name;
                                    @endphp
                                    <li class="{{ ($channel==$ch->id)?'active':'' }}"><a href="?date={{ $date }}&goal={{ $goal}}&supervisor={{ $supervisor }}&channel={{ $ch->id }}">{{ $ch->name }}</a></li>
                                @endforeach
                            </ul>: <span class="small text-info">{{ $label }}</span>
                        </div>
                    </div>
                </div>
                <!-- Contacts -->
                <table class="table is-indent tablesaw" data-tablesaw-mode="stack" data-plugin="animateList"
                       data-animate="fade" data-child="tr" data-selectable="selectable">
                    <thead>
                    <tr>
                        <th class="pre-cell"></th>
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Usuario</th>
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Jefe</th>
                        <th class="cell-300" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Meta</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Periodo / Liquidado</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Cumple</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Puntos</th>
                        <th class="suf-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($values as $value)
                        @if($value->goal)
                            <tr>
                                <td class="pre-cell"></td>
                                <td class="cell-30">{{ $value->user->name }}<br>
                                    <span class="small text-info">{{ number_format($value->user->identification,0,',','.') }}</span>
                                </td>
                                <td class="cell-30">{{ ($value->user->parent)?$value->user->parent->name:'' }}<br>
                                    <span class="small text-info">{{ $value->user->parent?number_format($value->user->parent->identification,0,',','.'):'' }}</span>
                                </td>
                                <td class="cell-300">{{ $value->goal->name }}<br>
                                    <span class="text-info small">{{ $value->goal->challenge->name }}</span>
                                    @if($value->goal->type == 'compare')
                                        <span class="small text-info">{{ $value->goal->variable1_id?$value->goal->variable1->name:'' }}</span>
                                        <span class="small text-primary"><strong>{{ $value->goal->operator?$value->goal->operator:'' }}</strong></span>
                                        <span class="small text-info">{{ $value->goal->variable2_id?$value->goal->variable2->name:'' }}</span>
                                    @elseif($value->goal->type == 'multiply')
                                        <span class="small text-info">{{ $value->goal->variable1_id?$value->goal->variable1->name:'' }}</span>
                                        <span class="small text-primary"><strong>*</strong></span>
                                        <span class="small text-info">{{ $value->goal->variable2_id?$value->goal->variable2->name:'' }}</span>
                                    @elseif($value->goal->type == 'grouptotal')
                                        <span class="small text-info">{{ $value->goal->variable1_id?$value->goal->variable1->name:'' }}</span>
                                        <span class="small text-primary"><strong>{{ $value->goal->operator?$value->goal->operator:'' }}</strong></span>
                                        <span class="small text-info">{{ $value->goal->variable2_id?$value->goal->variable2->name:'' }}</span>
                                    @elseif($value->goal->type == 'composed')
                                        <span class="small text-info">{!! implode('<br>',$value->goal->goals->pluck('name')->toArray())  !!}</span>
                                    @endif
                                </td>
                                <td class="cell-30">{{ $value->period }}<br>
                                    <span class="text-info">{{ $value->updated_at }}</span>
                                </td>
                                <td class="cell-30">{{ $value->value?'Si':'No' }}</td>
                                <td class="cell-30">{{ $value->points }}</td>
                                <td class="suf-cell"></td>
                            </tr>
                        @endif
                    @empty
                        <tr><td colspan="8">No hay registros que coincidan con los filtros usados. Intente nuevamente cambiando algunos filtros.
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </td></tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $values->links() }}
            </div>
        </div>
    </div>
    @include('footer.complete')
@endsection
