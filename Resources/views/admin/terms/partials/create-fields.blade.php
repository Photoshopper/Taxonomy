<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
    {!! Form::label('parent_id', trans('taxonomy::terms.form.parent')) !!}
    {!! Form::select('parent_id', array(null => '< '.trans('taxonomy::terms.form.root').' >') + $terms, null, ['class' => 'form-control']) !!}
    {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}
</div>

@include('ImageManager::_scripts')
@include('ImageManager::_image-input', [
    'label' => 'Изображение',
    'field_name' => 'image',
    'upload_dir' => 'taxonomy',
    'size' => [100, 100]
])

{{ Form::hidden('vocabulary_id', $vocabulary_id) }}