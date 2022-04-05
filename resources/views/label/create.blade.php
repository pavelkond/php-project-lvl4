@extends('layouts.app')

@section('content')
    <h1>Создать метку</h1>

    {{ Form::open(['route' => 'labels.store', 'method' => 'post']) }}
        @include('label.form')
        {{ Form::submit('Создать') }}
    {{ Form::close() }}
@endsection
