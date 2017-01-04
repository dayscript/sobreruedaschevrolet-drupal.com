@extends('layouts.app',['classes'=>'page-profile'])

@section('title') {{ $profile->name }} @parent @endsection

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
<link rel="stylesheet" href="/remark/material/base/assets/examples/css/pages/profile.css">
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
<script>
    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
            Site.run();
        });
    })(document, window, jQuery);
</script>
@endsection

@section('content')
    @include('navbar.complete')
    @include('menubar.complete')
    <div class="page animsition">
        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Page Widget -->
                    <div class="widget widget-shadow text-center">
                        <div class="widget-header">
                            <div class="widget-header-content">
                                <a class="avatar avatar-lg" href="javascript:void(0)">
                                    <img src="{{ asset($profile->avatar) }}" alt="{{ $profile->name }}">
                                </a>
                                <h4 class="profile-user">{{ $profile->name }}</h4>
                                <p class="profile-job">{{ $profile->email }}</p>
                                <p><strong>Creación:</strong> {{ $profile->created_at }}<br>
                                <strong>Actualización:</strong> {{ $profile->updated_at }}</p>
                                {{--<div class="profile-social">--}}
                                    {{--<a class="icon bd-twitter" href="javascript:void(0)"></a>--}}
                                    {{--<a class="icon bd-facebook" href="javascript:void(0)"></a>--}}
                                    {{--<a class="icon bd-dribbble" href="javascript:void(0)"></a>--}}
                                    {{--<a class="icon bd-github" href="javascript:void(0)"></a>--}}
                                {{--</div>--}}
                                @can('edit',$profile)
                                    <button type="button" class="btn btn-primary">Editar</button>
                                @endcan
                            </div>
                        </div>
                        <div class="widget-footer">
                            <div class="row no-space">
                                <div class="col-xs-4">
                                    <strong class="profile-stat-count">0</strong>
                                    <span>Estrellas</span>
                                </div>
                                <div class="col-xs-4">
                                    <strong class="profile-stat-count">{{ number_format($profile->stats()->where('action','login')->count(),0,',','.') }}</strong>
                                    <span>Ingresos</span>
                                </div>
                                <div class="col-xs-4">
                                    <strong class="profile-stat-count">{{ number_format($profile->stats->count(),0,',','.') }}</strong>
                                    <span>Interacciones</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Page Widget -->
                </div>
                <div class="col-md-9">
                    <!-- Panel -->
                    <div class="panel">
                        <div class="panel-body nav-tabs-animate">
                            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                                <li class="active" role="presentation"><a data-toggle="tab" href="#activities" aria-controls="activities"
                                                                          role="tab">Actividad</a></li>
                                <li role="presentation"><a data-toggle="tab" href="#stars" aria-controls="stars" role="tab">Estrellas</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active animation-slide-left" id="activities" role="tabpanel">
                                    <ul class="list-group">
                                        @foreach($stats as $stat)
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-responsive" src="{{ asset(($stat->model && $stat->model->avatar)?$stat->model->avatar:$profile->avatar) }}" alt="{{ $profile->name }}">
                                                    </a>
                                                </div>

                                                <div class="media-body">
                                                    <h4 class="media-heading">{{ $profile->name }}
                                                        <span>{{ $stat->label() }}</span>
                                                    </h4>
                                                    <small>{{ $stat->created_at }}</small>
                                                    @if($description = $stat->description())
                                                        <div class="profile-brief">{!! $stat->description() !!}</div>
                                                    @endif
                                                </div>

                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    {{ $stats->links() }}
                                </div>
                                <div class="tab-pane animation-slide-left" id="stars" role="tabpanel">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="media media-lg">
                                                <div class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-responsive" src="{{ asset($profile->avatar) }}" alt="{{ $profile->name }}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">{{ $profile->name }}
                                                        <span>Activación</span>
                                                    </h4>
                                                    <small>{{ $profile->created_at }}</small>
                                                    <div class="profile-brief">Este usuario no tiene estrellas asignadas</div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="tab-pane animation-slide-left" id="messages" role="tabpanel">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-responsive" src="../../../global/portraits/2.jpg" alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">Ida Fleming
                                                        <span>posted an updated</span>
                                                    </h4>
                                                    <small>active 14 minutes ago</small>
                                                    <div class="profile-brief">“Check if it can be corrected with overflow : hidden”</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media media-lg">
                                                <div class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-responsive" src="../../../global/portraits/5.jpg" alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">Terrance Arnold
                                                        <span>posted a new blog</span>
                                                    </h4>
                                                    <small>active 14 minutes ago</small>
                                                    <div class="profile-brief">
                                                        <div class="media">
                                                            <a class="media-left">
                                                                <img class="media-object" src="../../../global/photos/placeholder.png" alt="...">
                                                            </a>
                                                            <div class="media-body padding-left-20">
                                                                <h4 class="media-heading">Getting Started</h4>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit. Integer nec odio. Praesent libero. Sed
                                                                    cursus ante dapibus diam. Sed nisi. Nulla quis
                                                                    sem at nibh elementum imperdiet. Duis sagittis
                                                                    ipsum. Praesent mauris.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-responsive" src="../../../global/portraits/4.jpg" alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">Owen Hunt
                                                        <span>posted a new note</span>
                                                    </h4>
                                                    <small>active 14 minutes ago</small>
                                                    <div class="profile-brief">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Integer nec odio. Praesent libero. Sed cursus ante
                                                        dapibus diam. Sed nisi. Nulla quis sem at nibh elementum
                                                        imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce
                                                        nec tellus sed augue semper porta. Mauris massa.</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a class="avatar" href="javascript:void(0)">
                                                        <img class="img-responsive" src="../../../global/portraits/3.jpg" alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">Julius
                                                        <span>posted an updated</span>
                                                    </h4>
                                                    <small>active 14 minutes ago</small>
                                                    <div class="profile-brief">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Integer nec odio. Praesent libero. Sed cursus ante
                                                        dapibus diam.</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Panel -->
                </div>
            </div>
        </div>
    </div>
    @include('footer.complete')
@endsection
