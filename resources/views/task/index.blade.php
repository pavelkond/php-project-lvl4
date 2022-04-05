@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Задачи</h1>

    <div class="d-flex mb-3">
        <div>
            {{ Form::open(['route' => 'tasks.index', 'method' => 'get']) }}
            <div class="row g-1">
                <div class="col">
                    {{ Form::select('filter[status_id]', $statuses, null, ['placeholder' => 'Статус', 'class' => 'form-select me-2']) }}
                </div>
                <div class="col">
                    {{ Form::select('filter[created_by_id]', $users, null, ['placeholder' => 'Автор', 'class' => 'form-select me-2']) }}
                </div>
                <div class="col">
                    {{ Form::select('filter[assigned_to_id]', $users, null, ['placeholder' => 'Исполнитель', 'class' => 'form-select me-2']) }}
                </div>
                <div class="col">
                    {{ Form::submit('Применить', ['class' => 'btn btn-outline-primary me-2']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
        <div class="ms-auto">
            @if(Auth::check())
                {{ Form::open(['route' => 'tasks.create', 'method' => 'get']) }}
                {{ Form::submit('Создать задачу', ['class' => 'btn btn-primary ml-auto']) }}
                {{ Form::close() }}
            @endif
        </div>
    </div>

    <table class="table me-2">
        <tr>
            <th>ID</th>
            <th>Статус</th>
            <th>Имя</th>
            <th>Автор</th>
            <th>Исполнитель</th>
            <th>Дата создания</th>
            @if(Auth::check())
                <th>Действия</th>
            @endif
        </tr>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td>
                <td><a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a></td>
                <td>{{ $task->createdBy->name }}</td>
                <td>{{ $task->assignedTo->name ?? ''}}</td>
                <td>{{ $task->created_at }}</td>
                @if(Auth::check())
                    <td>
                        <div class="row g-1">
                            @can('delete', $task)
                                <div class="col">
                                    {{ Form::open(['route' => ['tasks.destroy', $task], 'method' => 'delete']) }}
                                    {{ Form::submit('Удалить', ['class' => 'btn btn-danger']) }}
                                    {{ Form::close() }}
                                </div>
                            @endcan

                            <div class="col">
                                {{ Form::open(['route' => ['tasks.edit', $task], 'method' => 'get']) }}
                                    {{ Form::submit('Изменить', ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@endsection
