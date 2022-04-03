@extends('layouts.app')

@section('content')
    <h1>Создать задачу</h1>

    {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'patch']) }}
        @include('task.form')
        {{ Form::submit('Обновить') }}
    {{ Form::close() }}
@endsection
