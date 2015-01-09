@extends('layouts.master')

@section('content')

    {{Form::open(['url'=>'/login'])}}

        {{ $errors->first('username', '<span class="error">:message</span>') }}
        {{Form::label('username', 'Username:')}} {{Form::text( 'username')}}

        {{ $errors->first('password', '<span class="error">:message</span>') }}
        {{Form::label('password', 'Password:')}} {{Form::password( 'password')}}

        {{Form::checkbox( 'remember', 1, null, ['id' => 'remember'] )}} {{Form::label('remember', 'Remember me')}}

        {{Form::submit('Login')}}

    {{Form::close()}}

@stop