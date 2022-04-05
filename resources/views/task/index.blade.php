@extends('layouts.app')

@section('content')
    <h1>Задачи</h1>

    {{ Form::open(['route' => 'tasks.index', 'method' => 'get']) }}
        {{ Form::select('filter[status_id]', $statuses, null, ['placeholder' => 'Статус']) }}
        {{ Form::select('filter[created_by_id]', $users, null, ['placeholder' => 'Автор']) }}
        {{ Form::select('filter[assigned_to_id]', $users, null, ['placeholder' => 'Исполнитель']) }}
        {{ Form::submit('Применить') }}
    {{ Form::close() }}

    @if(Auth::check())
        {{ Form::open(['route' => 'tasks.create', 'method' => 'get']) }}
            {{ Form::submit('Создать задачу') }}
        {{ Form::close() }}
    @endif

    <table>
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
                        {{ Form::open(['route' => ['tasks.edit', $task], 'method' => 'get']) }}
                            {{ Form::submit('Изменить') }}
                        {{ Form::close() }}

                        @can('delete', $task)
                            {{ Form::open(['route' => ['tasks.destroy', $task], 'method' => 'delete']) }}
                                {{ Form::submit('Удалить') }}
                            {{ Form::close() }}
                        @endcan
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@endsection
