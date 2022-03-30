@extends('layouts.app')

@section('content')
    <h1>Статусы</h1>

    @if(Auth::check())
        <a href="{{ route('task_statuses.create') }}">Создать статус</a>
    @endif

    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Дата создания</th>
            @if(Auth::check())
                <th>Действия</th>
            @endif
        </tr>
        @foreach($taskStatuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>{{ $status->created_at }}</td>
                @if(Auth::check())
                    <td>
                        {{ Form::open(['route' => ['task_statuses.destroy', $status], 'method' => 'delete']) }}
                            {{ Form::submit('Удалить') }}
                        {{ Form::close() }}

                        {{ Form::open(['route' => ['task_statuses.edit', $status], 'method' => 'get']) }}
                            {{ Form::submit('Изменить') }}
                        {{ Form::close() }}
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@endsection
