<div class="form-group mb-3">
    {{ Form::label('name', 'Имя') }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
    @error('name')
    <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group mb-3">
    {{ Form::label('description', '') }}
    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    @error('description')
    <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group mb-3">
    {{ Form::label('status_id', '') }}
    {{ Form::select('status_id', $statuses, null, ['placeholder' => '----------', 'class' => 'form-control']) }}
    @error('status_id')
    <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group mb-3">
    {{ Form::label('assigned_to_id', '') }}
    {{ Form::select('assigned_to_id', $users, null, ['placeholder' => '----------', 'class' => 'form-control']) }}
    @error('assigned_to_id')
    <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group mb-3">
    {{ Form::label('labels[]', 'Метки') }}
    {{ Form::select('labels[]', $labels, null, ['placeholder' => '----------', 'multiple' => 'multiple', 'class' => 'form-control']) }}
    @error('labels')
    <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
