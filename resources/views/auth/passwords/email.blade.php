@extends('layouts.app',['classes'=>'page-login-v2 layout-full page-dark'])

@section('title') Ingresar @parent @endsection

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
<link rel="stylesheet" href="/remark/material/base/assets/examples/css/pages/login-v2.css">
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

@section('content')
    <div class="page animsition" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content">
            <div class="page-brand-info">
                <div class="brand">
                    <img class="brand-img" src="/images/logo_sodexo_white.png" alt="...">
                    <h2 class="brand-text font-size-40">Liquidador</h2>
                </div>
                <p class="font-size-20">Plataforma para la gestión de las liquidaciones de beneficios de los clientes de Sodexo.</p>
            </div>
            <div class="page-login-main">
                <div class="brand visible-xs">
                    <img class="brand-img" src="/images/logo_sodexo.png" alt="...">
                    <h3 class="brand-text font-size-40">Liquidador</h3>
                </div>
                <h3 class="font-size-24">Olvidé mi contraseña</h3>
                <p>Para recuperar su contraseña, ingrese sus datos</p>

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Correo electrónico</label>

                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-envelope"></i>Enviar enlace al correo
                            </button>
                        </div>
                    </div>
                </form>

                <p>Regresar a <a href="/login">Iniciar sesión</a></p>
                <footer class="page-copyright">
                    <p>Desarrollado por <a href="http://www.dayscript.com" target="_blank">Dayscript SAS</a><br> para <a href="http://co.sodexo.com/"
                                                                                                                         target="_blank">Sodexo Colombia</a>
                    </p>
                    <p>© {{ date('Y') }}. Todos los derechos reservados.</p>
                    <div class="social">
                        <a class="btn btn-icon btn-round social-twitter" href="javascript:void(0)">
                            <i class="icon bd-twitter" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-round social-facebook" href="javascript:void(0)">
                            <i class="icon bd-facebook" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-round social-google-plus" href="javascript:void(0)">
                            <i class="icon bd-google-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
    <script src="/remark/material/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
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
    <script src="/remark/material/global/js/components/jquery-placeholder.js"></script>
    <script src="/remark/material/global/js/components/material.js"></script>
    <script>
        (function (document, window, $) {
            'use strict';
            var Site = window.Site;
            $(document).ready(function () {
                Site.run();
            });
        })(document, window, jQuery);
    </script>
@endsection
