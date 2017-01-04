@extends('layouts.app',['classes'=>'dashboard'])

@section('title') Dashboard @parent @endsection

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
<link rel="stylesheet" href="/remark/material/global/vendor/chartist-js/chartist.css">
<link rel="stylesheet" href="/remark/material/global/vendor/jvectormap/jquery-jvectormap.css">
<link rel="stylesheet" href="/remark/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
<link rel="stylesheet" href="/remark/material/base/assets/examples/css/dashboard/v1.css">
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
<script src="/remark/material/global/vendor/chartist-js/chartist.min.js"></script>
<script src="/remark/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script>
<script src="/remark/material/global/vendor/jvectormap/jquery-jvectormap.min.js"></script>
<script src="/remark/material/global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<script src="/remark/material/global/vendor/jvectormap/maps/jquery-jvectormap-co-mill.js"></script>
<script src="/remark/material/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="/remark/material/global/vendor/peity/jquery.peity.min.js"></script>
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
<script src="/remark/material/global/js/components/matchheight.js"></script>
<script src="/remark/material/global/js/components/jvectormap.js"></script>
<script src="/remark/material/global/js/components/peity.js"></script>
<script src="/remark/material/base/assets/examples/js/dashboard/v1.js"></script>
@endsection

@section('content')
@include('navbar.complete')
@include('menubar.complete')
        <!-- Page -->
<div class="page animsition">
    <div class="page-content padding-30 container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea One-->
                <div class="widget widget-shadow" id="widgetLineareaOne">
                    <div class="widget-content">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-account grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> Usuarios
                                </div>
                                <span class="pull-right grey-700 font-size-30">{{ \App\User::count() }}</span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <i class="icon md-long-arrow-up green-500 font-size-16"></i> 15% Desde ayer
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                    </div>
                </div>
                <!-- End Widget Linearea One -->
            </div>
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea Two -->
                <div class="widget widget-shadow" id="widgetLineareaTwo">
                    <div class="widget-content">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-flash grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> Interacciones
                                </div>
                                <span class="pull-right grey-700 font-size-30">{{ \App\Manager\User\Stat::count() }}</span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <i class="icon md-long-arrow-up green-500 font-size-16"></i> 34.2% Esta semana
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                    </div>
                </div>
                <!-- End Widget Linearea Two -->
            </div>
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea Three -->
                <div class="widget widget-shadow" id="widgetLineareaThree">
                    <div class="widget-content">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-chart grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> Ingresos
                                </div>
                                <span class="pull-right grey-700 font-size-30">{{ \App\Manager\User\Stat::where('action','login')->count() }}</span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <i class="icon md-long-arrow-down red-500 font-size-16"></i> 15% Desde ayer
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                    </div>
                </div>
                <!-- End Widget Linearea Three -->
            </div>
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea Four -->
                <div class="widget widget-shadow" id="widgetLineareaFour">
                    <div class="widget-content">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-view-list grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> Estrellas
                                </div>
                                <span class="pull-right grey-700 font-size-30">0</span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <i class="icon md-long-arrow-up green-500 font-size-16"></i> 0% Desde el mes anterior
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                    </div>
                </div>
                <!-- End Widget Linearea Four -->
            </div>
            <div class="clearfix"></div>
            {{--<div class="col-xlg-7 col-md-7">--}}
                {{--<!-- Widget Jvmap -->--}}
                {{--<div class="widget widget-shadow">--}}
                    {{--<div class="widget-content">--}}
                        {{--<div id="widgetJvmap" class="height-450"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- End Widget Jvmap -->--}}
            {{--</div>--}}
            {{--<div class="col-xlg-5 col-md-5">--}}
                {{--<!-- Widget Current Chart -->--}}
                {{--<div class="widget widget-shadow" id="widgetCurrentChart">--}}
                    {{--<div class="padding-30 white bg-green-500">--}}
                        {{--<div class="font-size-20 margin-bottom-20">The current chart</div>--}}
                        {{--<div class="ct-chart height-200">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="bg-white padding-30 font-size-14">--}}
                        {{--<div class="counter counter-lg text-left">--}}
                            {{--<div class="counter-label margin-bottom-5">Approve rate are above average</div>--}}
                            {{--<div class="counter-number-group">--}}
                                {{--<span class="counter-number">12,673</span>--}}
                                {{--<span class="counter-number-related text-uppercase font-size-14">pcs</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<button type="button" class="btn-raised btn btn-info btn-floating">--}}
                            {{--<i class="icon md-plus" aria-hidden="true"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- End Widget Current Chart -->--}}
            {{--</div>--}}

            <!-- Widget User list -->
            <?php $i=1?>
            @foreach(\App\User::latest()->take(3)->get() as $us)
                <div class="col-lg-4 col-md-6">
                    @include('dashboard.userwidget',['us'=>$us,'counter'=>$i])
                </div>
            <?php $i++;?>
            @endforeach
                        <!-- End Widget User list -->

                {{--<div class="col-lg-4 col-md-6">--}}
                    {{--<!-- Widget Chat -->--}}
                    {{--<div class="widget widget-shadow" id="chat">--}}
                        {{--<div class="widget-content padding-vertical-20">--}}
                            {{--<div class="widget-chat-header">--}}
                                {{--<a class="pull-left" href="javascript:void(0)">--}}
                                    {{--<i class="icon md-chevron-left" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                                {{--<div class="text-right">--}}
                                    {{--Conversation with--}}
                                    {{--<span class="hidden-xs">June Lane</span>--}}
                                    {{--<a class="avatar margin-left-15" data-toggle="tooltip" href="#" data-placement="right"--}}
                                       {{--title="June Lane">--}}
                                        {{--<img src="{{ asset('images/portraits/4.jpg') }}" alt="...">--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="chats">--}}
                                {{--<div class="chat">--}}
                                    {{--<div class="chat-body">--}}
                                        {{--<div class="chat-content" data-toggle="tooltip" title="11:37:08 am">--}}
                                            {{--<p>Good morning, sir.</p>--}}
                                            {{--<p>What can I do for you?</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="chat">--}}
                                    {{--<div class="chat-body chat-right">--}}
                                        {{--<div class="chat-content" data-toggle="tooltip" title="11:39:57 am">--}}
                                            {{--<p>Well, I am just looking around.</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="chat">--}}
                                    {{--<div class="chat-body">--}}
                                        {{--<div class="chat-content" data-toggle="tooltip" title="11:40:10 am">--}}
                                            {{--<p>If necessary, please ask me.</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="widget-chat-footer">--}}
                                {{--<form>--}}
                                    {{--<div class="input-group form-material">--}}
                    {{--<span class="input-group-btn">--}}
                      {{--<a href="javascript: void(0)" class="btn btn-pure btn-default icon md-camera"></a>--}}
                    {{--</span>--}}
                                        {{--<input class="form-control" type="text" placeholder="Type message here ...">--}}
                    {{--<span class="input-group-btn">--}}
                      {{--<buttn type="button" class="btn btn-pure btn-default icon md-mail-send">--}}
                          {{--</button>--}}
                    {{--</span>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- End Widget Chat -->--}}
                {{--</div>--}}
                {{--<div class="col-lg-4 col-md-6">--}}
                    {{--<!-- Widget Info -->--}}
                    {{--<div class="widget widget-shadow">--}}
                        {{--<div class="widget-header cover overlay">--}}
                            {{--<div class="cover-background height-200"--}}
                                 {{--style="background-image: url('{{ asset('images/photos/placeholder.png') }}')"></div>--}}
                        {{--</div>--}}
                        {{--<div class="widget-body padding-horizontal-30 padding-vertical-20" style="height:calc(100% - 250px);">--}}
                            {{--<div class="margin-bottom-10" style="margin-top: -70px;">--}}
                                {{--<a class="avatar avatar-100 bg-white img-bordered" href="javascript:void(0)">--}}
                                    {{--<img src="{{ asset('images/users/female_01.png') }}" alt="">--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            {{--<div class="margin-bottom-20">--}}
                                {{--<div class="font-size-20">Caleb Richards</div>--}}
                                {{--<div class="font-size-14 grey-500">--}}
                                    {{--<span>2 hours ago</span> |--}}
                                    {{--<span>Comments 20</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<p>--}}
                                {{--Lorem ipsum dolLorem ip sum dolor sit amet, consectetur adipiscing elit. Integer--}}
                                {{--nec odio. Praesent libero.or sit amet, consectetur adipiscing elit.--}}
                                {{--Integer nec odio. Praesent libero.--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- End Widget Info -->--}}
                {{--</div>--}}
                <div class="col-xlg-5 col-md-6">
                    <!-- Panel Projects -->
                    <div class="panel" id="projects">
                        <div class="panel-heading">
                            <h3 class="panel-title">Programas</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>Programas</td>
                                    <td>Estado</td>
                                    <td>Fecha</td>
                                    <td>Acciones</td>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(\App\Manager\Programs\Program::all() as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>
                                        <span data-plugin="peityPie" data-skin="red">7/10</span>
                                    </td>
                                    <td>{{ $project->created_at }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip"
                                                data-original-title="Editar">
                                            <i class="icon md-wrench" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip"
                                                data-original-title="Eliminar">
                                            <i class="icon md-close" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td>No hay programas</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Panel Projects -->
                </div>
                <div class="col-xlg-7 col-md-6">
                    <!-- Panel Projects Status -->
                    <div class="panel" id="projects-status">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Desafíos
                                <span class="badge badge-info">2</span>
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Desafío</td>
                                    <td>Estado</td>
                                    <td class="text-left">Progreso</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>619</td>
                                    <td>Desafío de prueba 1</td>
                                    <td>
                                        <span class="label label-primary">Segmento</span>
                                    </td>
                                    <td>
                                        <span data-plugin="peityLine">5,3,2,-1,-3,-2,2,3,5,2</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>619</td>
                                    <td>Desafío de prueba 2</td>
                                    <td>
                                        <span class="label label-primary">Segmento</span>
                                    </td>
                                    <td>
                                        <span data-plugin="peityLine">5,3,2,-1,-3,-2,2,3,5,2</span>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Panel Projects Stats -->
                </div>
        </div>
    </div>
</div>
<!-- End Page -->
@include('footer.complete')
@endsection
