{{ Form::label('name', 'Имя') }}
{{ Form::text('name') }} <br>
{{ Form::label('description', '') }}
{{ Form::textarea('description') }} <br>
{{ Form::label('status_id', '') }}
{{ Form::select('status_id', $statusSelect, null, ['placeholder' => '----------']) }} <br>
{{ Form::label('assigned_to_id', '') }}
{{ Form::select('assigned_to_id', $assignerSelect, null, ['placeholder' => '----------']) }} <br>
