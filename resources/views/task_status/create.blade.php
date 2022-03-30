@extends('layouts.app')

@section('content')
    <h1>Создать статус</h1>

    {{ Form::open(['route' => 'task_statuses.store', 'method' => 'post']) }}
        {{ Form::label('name', 'Имя') }}
        {{ Form::text('name') }}
        {{ Form::submit('Создать') }}
    {{ Form::close() }}
@endsection
