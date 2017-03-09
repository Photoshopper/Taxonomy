<div class='form-group{{ $errors->has("$lang.name") ? ' has-error' : '' }}'>
    <?php $oldName = isset($vocabulary->translate($lang)->name) ? $vocabulary->translate($lang)->name : ''; ?>
    {!! Form::label("{$lang}[name]", trans('taxonomy::vocabularies.form.name') . ' *') !!}
    {!! Form::text("{$lang}[name]", old("$lang.name", $oldName), ['class' => 'form-control']) !!}
    {!! $errors->first("$lang.name", '<span class="help-block">:message</span>') !!}
</div>