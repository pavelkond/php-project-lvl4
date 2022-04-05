@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Создать метку</h1>

    {{ Form::open(['route' => 'labels.store', 'method' => 'post', 'class' => 'w-50']) }}
        @include('label.form')
        {{ Form::submit('Создать', ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}
@endsection
