{{-- Using extend template, it doesn't need redundant code
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Use the .env property APP_NAME and if it's not there will use the second parameter -->
        <title>{{config('app.name', 'LSAPP 2')}}</title>
    </head>
    <body>
        <h1>Welcome to Laravel</h1>
        <p>First website made with Laravel to learn the uses of the framework</p>
    </body>
    
</html> --}}
@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>First website made with Laravel to learn the uses of the framework</p>
        <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
    </div>
@endsection