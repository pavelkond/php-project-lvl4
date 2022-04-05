@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Изменение статуса</h1>

    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'patch', 'class' => 'w-50' ]) }}
        <div class="form-group mb-3">
            {{ Form::label('name', 'Имя') }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @error('name')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        {{ Form::submit('Обновить', ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}
@endsection
