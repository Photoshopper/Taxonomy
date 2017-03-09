<div class='form-group{{ $errors->has("$lang.name") ? ' has-error' : '' }}'>
    <?php $oldName = isset($term->translate($lang)->name) ? $term->translate($lang)->name : ''; ?>
    {!! Form::label("{$lang}[name]", trans('taxonomy::terms.form.name')) !!}
    {!! Form::text("{$lang}[name]", old("$lang.name", $oldName), ['class' => 'form-control', 'data-slug' => 'source']) !!}
    {!! $errors->first("$lang.name", '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has("$lang.slug") ? ' has-error' : '' }}'>
    <?php $oldSlug = isset($term->translate($lang)->slug) ? $term->translate($lang)->slug : ''; ?>
    {!! Form::label("{$lang}[slug]", trans('taxonomy::terms.form.slug')) !!}
    {!! Form::text("{$lang}[slug]", old("$lang.slug", $oldSlug), ['class' => 'form-control slug', 'data-slug' => 'target']) !!}
    {!! $errors->first("$lang.slug", '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has("$lang.description") ? ' has-error' : '' }}'>
    <?php $oldDesc = isset($term->translate($lang)->description) ? $term->translate($lang)->description : ''; ?>
    {!! Form::label("{$lang}[description]", trans('taxonomy::terms.form.description')) !!}
    {!! Form::textarea("{$lang}[description]", old("$lang.description", $oldDesc), ['class' => 'form-control ckeditor']) !!}
    {!! $errors->first("$lang.description", '<span class="help-block">:message</span>') !!}
</div>

<div class="box-group" id="accordion">
    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
    <div class="panel box box-primary">
        <div class="box-header">
            <h4 class="box-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                    {{ trans('page::pages.form.meta_data') }}
                </a>
            </h4>
        </div>
        <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
            <div class="box-body">
                <div class='form-group{{ $errors->has("{$lang}[meta_title]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_title]", trans('page::pages.form.meta_title')) !!}
                    <?php $old = $term->hasTranslation($lang) ? $term->translate($lang)->meta_title : '' ?>
                    {!! Form::text("{$lang}[meta_title]", old("{$lang}.meta_title", $old), ['class' => "form-control"]) !!}
                    {!! $errors->first("{$lang}[meta_title]", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("{$lang}[meta_keywords]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_keywords]", trans('taxonomy::terms.form.meta_keywords')) !!}
                    <?php $old = $term->hasTranslation($lang) ? $term->translate($lang)->meta_keywords : '' ?>
                    {!! Form::text("{$lang}[meta_keywords]", old("{$lang}.meta_keywords", $old), ['class' => "form-control"]) !!}
                    {!! $errors->first("{$lang}[meta_keywords]", '<span class="help-block">:message</span>') !!}
                </div>
                <div class='form-group{{ $errors->has("{$lang}[meta_description]") ? ' has-error' : '' }}'>
                    {!! Form::label("{$lang}[meta_description]", trans('page::pages.form.meta_description')) !!}
                    <?php $old = $term->hasTranslation($lang) ? $term->translate($lang)->meta_description : '' ?>
                    <textarea class="form-control" name="{{$lang}}[meta_description]" rows="10" cols="80">{{ old("$lang.meta_description", $old) }}</textarea>
                    {!! $errors->first("{$lang}[meta_description]", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>