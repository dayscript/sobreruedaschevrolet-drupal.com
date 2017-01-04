<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    @section('meta')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    @show
    <title>@section('title') | Sodexo @show</title>
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @yield('styles')
        <link rel="stylesheet" href="{{ elixir('css/main.css') }}">
        <link rel="stylesheet" href="/remark/material//global/vendor/toastr/toastr.css">
        <link rel="stylesheet" href="/remark/material/base/assets/examples/css/advanced/toastr.css">

</head>
<body id="app" class="{{ $classes or '' }}">
<!--[if lt IE 8]>
<p class="browserupgrade">Estas usando un navegador <strong>desactualizado</strong>. Por favor <a
        href="http://browsehappy.com/">actualiza tu navegador</a> para mejorar tu experiencia.</p>
<![endif]-->
@yield('content')
<script src="{{ elixir('js/bundle.js') }}"></script>
@yield('scripts')
<script src="/remark/material/global/vendor/toastr/toastr.js"></script>
<script src="/remark/material/global/js/components/toastr.js"></script>
<script src="http://cdn.jsdelivr.net/vue/1.0.21/vue.js"></script>
@include('flash::message')
<script>
    $('#flash-overlay-modal').modal();
</script>

</body>
</html>