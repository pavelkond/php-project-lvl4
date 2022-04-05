@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Метки</h1>

    @if(Auth::check())
        {{ Form::open(['route' => 'labels.create', 'method' => 'get']) }}
            {{ Form::submit('Создать метку', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    @endif

    <table class="table mt-2">
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
                        <div class="row g-1">
                            <div class="col">
                                {{ Form::open(['route' => ['labels.destroy', $label], 'method' => 'delete']) }}
                                    {{ Form::submit('Удалить', ['class' => 'btn btn-danger']) }}
                                {{ Form::close() }}
                            </div>
                            <div class="col">
                                {{ Form::open(['route' => ['labels.edit', $label], 'method' => 'get']) }}
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
