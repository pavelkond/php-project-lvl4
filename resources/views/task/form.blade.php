{{ Form::label('name', 'Имя') }}
{{ Form::text('name') }} <br>
{{ Form::label('description', '') }}
{{ Form::textarea('description') }} <br>
{{ Form::label('status_id', '') }}
{{ Form::select('status_id', $statuses, null, ['placeholder' => '----------']) }} <br>
{{ Form::label('assigned_to_id', '') }}
{{ Form::select('assigned_to_id', $users, null, ['placeholder' => '----------']) }} <br>
{{ Form::label('labels[]', 'Метки') }}
{{ Form::select('labels[]', $labels, null, ['placeholder' => '----------', 'multiple' => 'multiple']) }} <br>
