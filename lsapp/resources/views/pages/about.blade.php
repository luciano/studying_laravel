{{-- <!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Use the .env property APP_NAME and if it's not there will use the second parameter -->
        <title>{{config('app.name', 'LSAPP 2')}}</title>
    </head>
    <body>
        <h1>About</h1>
        <p>This is the about page</p>
    </body>
    
</html> --}}
@extends('layouts.app')

@section('content')
    <h1>About</h1>
    <p>This is the about page</p>
@endsection