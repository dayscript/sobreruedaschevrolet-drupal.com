@extends('layouts.email')
@section('content')
    @include('emails.articleStart')
    <h4 class="secondary"><strong>Hola {{ $user->name }}</strong></h4>
    <p>Has aceptado los términos y condiciones del programa.
        Te estamos enviando una copia para tu posterior referencia. <strong>Gracias!</strong></p>
    @include('emails.articleEnd')
    @include('emails.newfeatureStart')
    {!! nl2br($program->terms) !!}
    @include('emails.newfeatureEnd')
@stop
