@extends('layouts.app')

@section('content')
    <h1>Метки</h1>

    @if(Auth::check())
        {{ Form::open(['route' => 'labels.create', 'method' => 'get']) }}
            {{ Form::submit('Создать метку') }}
        {{ Form::close() }}
    @endif

    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Описание</th>
            <th>Дата создания</th>
            @if(Auth::check())
                <th>Действия</th>
            @endif
        </tr>
        @foreach($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at }}</td>
                @if(Auth::check())
                    <td>
                        {{ Form::open(['route' => ['labels.destroy', $label], 'method' => 'delete']) }}
                            {{ Form::submit('Удалить') }}
                        {{ Form::close() }}

                        {{ Form::open(['route' => ['labels.edit', $label], 'method' => 'get']) }}
                            {{ Form::submit('Изменить') }}
                        {{ Form::close() }}
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@endsection
