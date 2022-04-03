@extends('layouts.app')

@section('content')
    <h1>Просмотр задачи: {{ $task->name }}</h1>
    <a href="{{ route('tasks.edit', $task) }}">⚙</a>
    <div>
        <p>Имя: {{ $task->name }}</p>
        <p>Статус: {{ $task->status->name }}</p>
        <p>Описание: {{ $task->description }}</p>
        <p>Метки:</p>
        <ul>

        </ul>
    </div>
@endsection
