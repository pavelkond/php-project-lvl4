@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Статусы</h1>

    @if(Auth::check())
        <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>
    @endif

    <table class="table mt-2">
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
                        <div class="row g-1">
                            <div class="col">
                                {{ Form::open(['route' => ['task_statuses.destroy', $status], 'method' => 'delete']) }}
                                    {{ Form::submit('Удалить', ['class' => 'btn btn-danger']) }}
                                {{ Form::close() }}
                            </div>
                            <div class="col">
                                {{ Form::open(['route' => ['task_statuses.edit', $status], 'method' => 'get']) }}
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
