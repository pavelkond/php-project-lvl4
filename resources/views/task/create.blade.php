@extends('layouts.app')

@section('content')
    <h1>Создать задачу</h1>

    {{ Form::open(['route' => 'tasks.store', 'method' => 'post']) }}
        @include('task.form')
        {{ Form::submit('Создать') }}
    {{ Form::close() }}
@endsection
