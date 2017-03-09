<div class='form-group{{ $errors->has("machine_name") ? ' has-error' : '' }}'>
    {!! Form::label("machine_name", trans('taxonomy::vocabularies.form.machine_name') . ' *') !!}
    {!! Form::text("machine_name", old("machine_name"), ['class' => 'form-control']) !!}
    {!! $errors->first("machine_name", '<span class="help-block">:message</span>') !!}
</div>