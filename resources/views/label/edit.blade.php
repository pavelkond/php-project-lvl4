@extends('layouts.app')

@section('content')
    <h1>Изменение метки</h1>

    {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'patch']) }}
        @include('label.form')
        {{ Form::submit('Обновить') }}
    {{ Form::close() }}
@endsection
