@extends('layouts.email')
@section('content')
    @include('emails.articleStart')
    <h4 class="secondary"><strong>Hola {{ $user->name }}</strong></h4>
    <p>Se ha hecho una solicitud para restablecer tu contraseña en la plataforma de Liquidaciones de Sodexo.</p>
    @include('emails.articleEnd')
    @include('emails.newfeatureStart')
    Haga click aquí para establecer una nueva contraseña: <br>
    <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
    @include('emails.newfeatureEnd')
@stop