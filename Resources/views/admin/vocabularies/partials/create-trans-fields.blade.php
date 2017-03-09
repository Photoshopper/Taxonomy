<div class='form-group{{ $errors->has("$lang.name") ? ' has-error' : '' }}'>
    {!! Form::label("{$lang}[name]", trans('taxonomy::vocabularies.form.name') . ' *') !!}
    {!! Form::text("{$lang}[name]", old("$lang.name"), ['class' => 'form-control']) !!}
    {!! $errors->first("$lang.name", '<span class="help-block">:message</span>') !!}
</div>

