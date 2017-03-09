@extends('layouts.master')

@section('content-header')
    <h1>
        {{ $vocabulary->name }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.taxonomy.vocabulary.index') }}">{{ trans('taxonomy::vocabularies.title.vocabularies') }}</a></li>
        <li class="active">{{ $vocabulary->name }}</li>
    </ol>
@stop

@section('styles')
    <link href="{!! Module::asset('menu:css/nestable.css') !!}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.taxonomy.term.create', [$vocabulary->id]) }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('taxonomy::terms.button.create term') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    {!! $taxonomy_menu !!}
                </div>
                @if($taxonomy_menu != trans('taxonomy::terms.table.no terms'))
                    <div class="box-footer">
                        {!! Form::submit(trans('taxonomy::terms.table.save'), ['class' => 'btn btn-primary saveTaxonomyMenu']) !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            {!! Form::open(['route' => ['admin.taxonomy.vocabulary.update', $vocabulary->id], 'method' => 'put']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('core::core.title.translatable fields') }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="nav-tabs-custom">
                                @include('partials.form-tab-headers')
                                <div class="tab-content">
                                    <?php $i = 0; ?>
                                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                        <?php $i++; ?>
                                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                            @include('taxonomy::admin.vocabularies.partials.edit-trans-fields', ['lang' => $locale])
                                        </div>
                                    @endforeach
                                </div>
                            </div> {{-- end nav-tabs-custom --}}
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
                        </div>
                        <div class="box-body">
                            @include('taxonomy::admin.vocabularies.partials.edit-fields')
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.taxonomy.vocabulary.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('taxonomy::terms.title.create term') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.taxonomy.term.create', [$vocabulary->id]) ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
    <script src="{!! Module::asset('menu:js/jquery.nestable.js') !!}"></script>
    <script>
        $('.dd').nestable({
            'collapseBtnHTML' : false,
            'expandBtnHTML' : false
        });

        $('.saveTaxonomyMenu').on('click', function() {
            var data = $('.dd').nestable('serialize');

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.taxonomy.term.ajaxUpdate') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    categories: data
                },
                dataType: 'json',
                success: function(data) {
                    if($('.alert').length == 0) {
                        $('.content').prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ '{{ trans('taxonomy::terms.messages.order saved') }}' +'</div>')
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log(xhr);
                }
            });
        });
    </script>
@stop
