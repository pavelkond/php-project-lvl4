@extends('layouts.app')

@section('content')
    <h1>Изменение статуса</h1>

    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'put']) }}
        {{ Form::label('name', 'Имя') }}
        {{ Form::text('name') }}
        {{ Form::submit('Обновить') }}
    {{ Form::close() }}
@endsection
